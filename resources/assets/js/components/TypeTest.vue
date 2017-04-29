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
          @keydown.delete="backspace"
          @keydown.esc="reset"
          @keydown.space="spacebar"
          type="text"
          :class="[{'is-danger is-wrong': incorrect}, 'input']"
          :placeholder="wordIndex = 0 ? 'Type the above text here to start' : ''"
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
        typingtest: [],
        userInput: '',
        typedWords: [],
        stopWatch: 60,
        wordIndex: 0,
        wordsIncorrect: 0,
        wordsCorrect: 0,
        wpm: 0,
      }
    },
    methods: {
      backspace () {
        console.log('user hit backspace')
        if (!!this.userInput) {
          console.log('increasing backspace count by 1')
          this.backspaceCount += 1
        }
        console.log('user input is currently:::: ' + this.userInput)
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
        this.wpm = 0,
        this.gettypingtest()
      },
      spacebar () {
        if (!this.userInput) {
          return;
        }
        if (this.userInput == this.wordList[this.wordIndex]) {
          console.log('user input matches word!')
          this.incorrect = false
          this.correctWords.push(this.wordList[this.wordIndex])
          this.wordsCorrect += 1
          this.wordIndex += 1
          this.userInput = ''
        } else {
          console.log('user input does not match!')
          this.incorrectWords.push(this.wordList[this.wordIndex])
          this.wordsIncorrect += 1
          this.incorrect = true
        }
        console.log('pressed space. increased wordIndex by 1. new word is ' + '\'' + this.wordList[this.wordIndex] + '\'')
      }
    },
    computed: {
      wordList () {
        return this.typingtest.text.split(' ')
      },
      currentWord () {
        return this.wordList[this.wordIndex]
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
  background-color: red * 0.1;
}
</style>
