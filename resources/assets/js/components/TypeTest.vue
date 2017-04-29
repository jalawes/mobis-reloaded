<template>
  <div class="section">
    <p>
      <strong>Status</strong>:
      <span :class="[{ 'activeWord': !loading }]">{{ feedback }}</span>
      <br>
      <span>Currently on word: {{ wordIndex }}</span>
    </p>
    <br>
    <div class="box">
      <div v-show="!loading">
        <div class="content">
          <p><strong>{{ typingtest.title }}</strong></p>
          <br><span :class="{'activeWord': wordIndex == $word}" v-for="(word, $word) in wordList">{{ word }} </span>
        </div>
      </div>
    </div>
    <div class="field">
      <p class="control">
        <input
          @keydown.space="spacebar"
          type="text"
          class="input"
          placeholder="Type the above text here to start"
          v-model="userInput"
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
        cpm: 0,
        feedback: '',
        goal: 100,
        loading: false,
        typingtest: [],
        userInput: '',
        typedWords: [],
        wordIndex: 0,
        wordsIncorrect: 0,
        wordsCorrect: 0,
        wpm: 0,
      }
    },
    methods: {
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
        this.loading = false
        this.feedback = 'Ready to start!'
        this.typingtest = {
          text: '',
          title: ''
        }
        this.userInput = ''
        this.wordsCorrect = 0
        this.wordsIncorrect = 0
        this.cpm = 0
        this.wpm = 0
        this.gettypingtest()
      },
      spacebar () {
        if (this.userInput == this.wordList[this.wordIndex]) {
          console.log('user input matches word!')
        } else {
          console.log('user input does not match!')
        }
        this.wordIndex += 1
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

<style scoped>
.inner-box {
  width: 80vw;
  height: 150px;
}
.activeWord {
  color: #34E500;
}
</style>
