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
      <span>Word: {{ wordIndex }} of paragraph {{ paragraphIndex + 1}} <em>(words remaining: {{ currentParagraph.length - wordIndex }})</em></span>
      <br>
      <span>Correctly Typed Words: {{ correctWords }}</span>
      <br>
      <span>Incorrectly Typed Words: {{ incorrectWords }}</span>
    </p>
    <br>
    <div class="box">
      <div v-show="!loading">
        <div class="content">
          <hr>
          <!-- current paragraph-->
          <p>{{ currentParagraph }}</p>
          <p v-for="remainingParagraph, $paragraphIndex in paragraphList" v-show="!!paragraphList[$paragraphIndex + 1]">{{ paragraphList[$paragraphIndex + 1] }}</p>
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
      }
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
        if (!!this.paragraphList) {
          return this.paragraphList.length
        }
      },
      paragraphList () {
        if (!!this.typingtest.text) {
          return this.typingtest.text.split(/\n/g)
        }
      },
      testTextCount () {
        if (this.typingtest.text) {
          return (this.typingtest.text).length
        }
      },
      userInputWithoutSpaces () {
        return this.userInput.split(' ').join('')
      },
      wordsInCurrentParagraph () {
        return this.currentParagraph.split(' ')
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
.activeWord {
  color: #34E500;
}
.content {
  max-height: 300px;
  overflow-y: scroll;
  font-size: 14px;
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
