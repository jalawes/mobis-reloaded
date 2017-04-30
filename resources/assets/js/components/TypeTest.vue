<template>
  <div class="section">
    <p>
      <strong>Status</strong>:
      <span :class="[{ 'activeWord': !loading }]">{{ feedback }}</span>
      <br>
      <span>Time Left: {{ stopWatch }}</span>
      <br>
      <span>Incorrect Words: {{ wordsIncorrect }}</span>
      <br>
      <span>Currently on word: {{ wordIndex }}</span>
      <br>
      <span>Correctly Typed Words: {{ correctWords }}</span>
      <br>
      <span>Incorrectly Typed Words: {{ incorrectWords }}</span>
    </p>
    <br>
    <div class="box">
      <div v-show="!loading">
        <div class="content">
          <p><strong>{{ typingtest.title }}</strong></p>
          <br><span :class="[{'activeWord': wordIndex == $word}, {'typedWord': $word < wordIndex}]" v-for="(word, $word) in wordList">{{ word }} </span>
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
    name: 'Typetypingtest',
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
          console.log(this.currentWord, 'is already an correct word')
        } else {
          console.log(this.currentWord, '+++++ added to incorrect words')
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
          // this.userInput = ''
          return
        }
        if (!!this.userInput) { // if user input is truthy, then do something
          console.log('increasing backspace count by 1') // backspace should reduce CPM --> ideally, no user should use the backspace
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
        .then(this.viewCurrentProblem) // load next problem into dom
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
      }
    },
    computed: {
      currentWord () {
        return this.wordList[this.wordIndex]
      },
      testTextCount () {
        return (this.typingtest.text).length
      },
      userInputWithoutSpaces () {
        return this.userInput.split(' ').join('')
      },
      wordList () {
        return this.typingtest.text.split(' ')
      },
      wpm () {
        return this.cpm / this.stopWatch
      }
    },
    created () {
      this.gettypingtest()
    }
}
</script>

<style scoped lang="scss">
.inner-box {
  width: 80vw;
  height: 150px;
}
.activeWord {
  color: #34E500;
}
.typedWord {
  color: gray;
  opacity: 0.5;
}
.incorrectWord {
  text-decoration: underline;
}
.is-wrong {
  background-color: red * 0.01;
  color: white;
}
</style>
