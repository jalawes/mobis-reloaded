<template>
  <div class="section">
    <!--<nav class="level">
      <div class="level-item has-text-centered">
        <div>
          <p class="heading">Status</p>
          <p class="title"><span :class="[{ 'activeWord': !loading }]">{{ feedback }}</span></p>
        </div>
      </div>
      <div class="level-item has-text-centered">
        <div>
          <p class="heading">Time Left</p>
          <p class="title"><span :class="[{ 'activeWord': !loading }]">{{ stopWatch }}</span></p>
        </div>
      </div>
    </nav>-->
    <div class="box">
      <div v-show="!loading">
        <div class="content">
          <h3>{{ typingtest.title }}</h3>
          <hr>
          <p>
            <span
              :class="[{ 'activeWord': wordIndex == $word }, { 'typedWord': $word < wordIndex }, { 'incorrectWord': incorrectWordsIndex.includes($word) }]"
              v-for="word, $word in wordList"
            >{{ word }} </span>
          </p>
        </div>
      </div>
    </div>
    <div class="field">
      <p class="control">
        <input
          class="is-large"
          @keydown="keyPress"
          @keydown.delete="backspace"
          @keydown.esc="reset"
          @keydown.space="spacebar"
          type="text"
          :class="[{'is-danger is-wrong': incorrect}, 'input']"
          :placeholder="wordIndex === 0 ? 'Type the above text here to start' : null"
          v-model.trim="userInput"
        >
      </p>
      <a class="button is-outlined" @click.prevent="finishTest">Send Results</a>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Typingtest',
    props: {
      user: {
        type: Object,
        required: true
      }
    },
    data () {
      return {
        backspaceCount: 0,
        correctWords: {},
        correctWordsIndex: [],
        cpm: 0,
        feedback: '',
        goal: 100,
        incorrect: false,
        incorrectWords: {},
        incorrectWordsIndex: [],
        loading: false,
        stopWatch: 60,
        typedWords: [],
        typingtest: [],
        userInput: '',
        wordIndex: 0,
        wordsIncorrect: 0,
        wordsCorrect: 0,
        wpm: 0,
      }
    },
    methods: {
      addCorrectWord () {
        this.incorrect = false
        this.wordsCorrect += 1
        this.wordIndex += 1
        this.userInput = ''
        if (this.correctWords[this.currentWord]) {
          console.log(this.currentWord, 'is already an correct word. adding to tally.')
          this.correctWords[this.currentWord] += 1
        } else {
          console.log(this.currentWord, '+++++ added to correct words!')
          this.correctWords[this.currentWord] = 1
          this.addToIndex('correctWordsIndex')
        }
      },
      addIncorrectWord () {
        this.incorrect = true
        this.wordsIncorrect += 1
        if (this.incorrectWords[this.currentWord]) {
          console.log(this.currentWord, '----- is already an incorrect word. adding to tally.')
          this.incorrectWords[this.currentWord] += 1
        } else {
          console.log(this.currentWord, '----- added to incorrect words')
          this.incorrectWords[this.currentWord] = 1
          this.addToIndex('incorrectWordsIndex')
        }
      },
      addToIndex(indexToAdd) {
        if (this[indexToAdd].includes(this.wordIndex)) {
          console.log('word already exists in', indexToAdd, 'index.', 'ignoring')
          return
        } else {
          console.log('first time getting that word wrong. adding to', indexToAdd, 'index.')
          this[indexToAdd].push(this.wordIndex)
        }
      },
      backspace () {
        console.log('user hit backspace')
        if (!this.userInputWithoutSpaces) {
          return
        }
        if (!!this.userInput) {
          this.backspaceCount += 1
          console.log('increasing backspace count by 1')
        }
      },
      finishTest () {
        this.loading = true
        axios.post('/api/test', {
          test_id: this.typingtest.id,
          user_id: this.user.id,
          back_space_count: this.backspaceCount,
          correct_words_count: this.wordsCorrect,
          correct_words: this.correctWords,
          incorrect_words_count: this.wordsIncorrect,
          incorrect_words: this.incorrectWords,
          wpm: this.wpm,
        })
        .then(response => {
          console.log(response.data)
          this.loading = false
        })
        .catch(errors => console.log(errors))
      },
      gettypingtest () {
        this.loading = true
        this.typingtest = {
          title: '',
          text: ''
        }
        this.feedback = 'Getting a new test...'
        axios.get('/api/test')
        .then(response => {
          console.log(response.data)
          this.typingtest = {
            id: response.data.id,
            title: response.data.title,
            text: response.data.text
          }
          this.loading = false
          this.feedback = 'Ready to start!'
        })
        .catch(errors => console.log(errors))
      },
      keyPress () {
        this.cpm += 1
      },
      reset () {
        this.cpm = 0,
        this.feedback = 'Resetting the test...',
        this.goal = 100,
        this.incorrect = false,
        this.loading = false,
        this.typingtest = [],
        this.userInput = '',
        this.typedWords = [],
        this.stopWatch = 60,
        this.wordIndex = 0,
        this.wordsIncorrect = 0,
        this.wordsCorrect = 0,
        this.gettypingtest()
      },
      startTimer () {
        setInterval (()=> {

        }, 1000)
      },
      spacebar () {
        if (!this.userInputWithoutSpaces) {
          this.userInput = this.userInputWithoutSpaces
          return
        }
        if (this.userInput == this.currentWord) {
          console.log('pressed space. increased wordIndex by 1. new word is ' + '\'' + this.currentWord + '\'')
          this.addCorrectWord()
        } else {
          this.addIncorrectWord()
        }
      },

    },
    computed: {
      currentWord () {
        if (!!this.wordList) {
          return this.wordList[this.wordIndex]
        }
      },
      testTextCount () {
        if (this.typingtest.text !== null | undefined) {
          return (this.typingtest.text).length
        }
      },
      userInputWithoutSpaces () {
        return this.userInput.split(' ').join('')
      },
      wordList () {
        return this.typingtest.text.split(' ')
      },
      wpm () {
        if (this.cpm / this.stopWatch) {
          return this.cpm / this.stopWatch
        }
      }
    },
    created () {
      this.gettypingtest()
    }
}
</script>

<style scoped lang="scss">
.activeWord {
  color: #34E500;
}
.content {
  max-height: 300px;
  overflow-y: hidden;
  line-height: 40px;
  font-size: 18px;
}
.typedWord {
  color: gray;
  opacity: 0.5;
}
.incorrectWord {
  text-decoration: none;
  position: relative;
  &:after {
    position: absolute;
    content: '';
    height: 1px;
    bottom: -1px;
    margin: 0 auto;
    left: -3px;
    right: 0px;
    width: 80%;
    background: red;
  }
}
.is-wrong {
  background-color: red * 0.01;
  color: white;
}
</style>
