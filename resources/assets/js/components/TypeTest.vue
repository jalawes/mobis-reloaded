<template>
  <div class="section">
    <p>
      <strong>Status</strong>:
      <span :class="[{ 'activeWord': !loading }]">{{ feedback }}</span>
      <br>
      <span><strong>Time Left</strong>: {{ stopWatch }}</span>
      <br>
      <span><strong>Incorrect Words</strong>: {{ wordsIncorrect }}</span>
      <br>
      <span><strong>Word</strong>: {{ wordIndex }} of paragraph {{ paragraphIndex + 1}} (<span class="activeWord">{{ wordList[wordIndex] }})</span></span>
      <br>
      <span><strong>Correctly Typed Words</strong>: {{ correctWords }}</span>
      <br>
      <span><strong>Incorrectly Typed Words</strong>: {{ incorrectWords }}</span>
    </p>
    <br>
    <div class="box">
      <div v-show="!loading">
        <div class="content">
          <h3>{{ typingtest.title }}</h3>
          <hr>
          <p>
            <span
              :class="[{ 'activeWord': wordIndex == $word }, { 'typedWord': $word < wordIndex }, {'incorrectWord': incorrectWords.includes(word)}]"
              v-for="word, $word in wordList"
            >{{ word }} </span>
          </p>
        </div>
      </div>
    </div>
    <div class="field">
      <p class="control">
        <input
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
      <p>{{ userInput }}</p>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Typingtest',
    data () {
      return {
        backspaceCount: 0,
        correctWords: [],
        cpm: 0,
        feedback: '',
        goal: 100,
        incorrect: false,
        incorrectWords: [],
        loading: false,
        paragraphIndex: 0,
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
        if (this.correctWords.includes(this.currentWord)) {
          console.log(this.currentWord, 'is already an correct word. ignoring.')
        } else {
          console.log(this.currentWord, '+++++ added to correct words!')
        }
      },
      addIncorrectWord () {
        this.incorrect = true
        this.wordsIncorrect += 1
        if (this.incorrectWords.includes(this.currentWord)) {
          console.log(this.currentWord, 'is already an incorrect word')
        } else {
          this.incorrectWords.push(this.currentWord)
          console.log(this.currentWord, '----- added to incorrect words')
        }
      },
      backspace () {
        console.log('user hit backspace')
        if (!this.userInputWithoutSpaces) {
          return
        }
        if (!!this.userInput) {
          console.log('increasing backspace count by 1')
          this.backspaceCount += 1
        }
        console.log('user input ===== ' + this.userInput)
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
      spacebar () {
        if (!this.userInputWithoutSpaces) {
          this.userInput = this.userInputWithoutSpaces
          return
        }
        if (this.userInput == this.currentWord) {
          this.addCorrectWord()
        } else {
          this.addIncorrectWord()
        }
        console.log('pressed space. increased wordIndex by 1. new word is ' + '\'' + this.currentWord + '\'')
      },

    },
    computed: {
      currentParagraph () {
        if (!!this.paragraphList) {
          return this.paragraphList[this.paragraphIndex]
        }
      },
      currentWord () {
        if (!!this.wordList) {
          return this.wordList[this.wordIndex]
        }
      },
      paragraphCount () {
        if (this.paragraphList !== undefined | null) {
          return this.paragraphList.length
        }
      },
      paragraphList () {
        if (!!this.typingtest.text) {
          return this.typingtest.text.split(/\n/g)
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
      wordsInCurrentParagraph () {
        return this.currentParagraph.split(' ')
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
  line-height: 30px;
  font-size: 16px;
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
