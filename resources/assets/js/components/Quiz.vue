<template>
<div class="content">
  <div>
    <div class="box">
      <div class="inner-box">
        <p v-show="!loading">{{ currentQuestion }}</p>
      </div>
    </div>
    <progress class="progress is-success is-small" value="100" max="100">100%</progress>
  </div>

  <div class="level">
    <div class="level-left"></div>
    <div class="level-right bottom-menu">
      <span class="nav-item">
        <p class="level-item">
          <a :class="[{'is-loading': loading}, ' button is-outlined']" @click.capture="getQuiz">Play</a>
          <a class="button is-outlined" @click="reset">Reset</a>
        </p>
      </span>
    </div>
  </div>
</div>
</template>

<script>
import LoadingModal from './LoadingModal'
export default {
  name: 'Quiz',
  props: {
    //
  },
  data () {
    return {
      loading: false,
      questionHistory: [],
      currentQuestion: null
    }
  },
  methods: {
    reset () {
      this.loading = true
      this.questionHistory = []
      this.currentQuestion = null
      this.loading = false
    },
    getQuiz () {
      this.loading = true
      this.currentQuestion = {}
      axios.get('/api/quiz')
        .then(response => {
          this.questionHistory.push(response.data)
          this.loading = false
        })
        .then(this.viewCurrentProblem) // load next problem into dom
        .catch(errors => console.log(errors))
    },
    viewCurrentProblem () {
      return this.currentQuestion = this.questionHistory[this.questionHistory.length - 1] // update latest problem
    }
  }
}
</script>

<style scoped>
.inner-box {
  width: 80vw;
  height: 30vh;
}
.component-fade-enter-active, .component-fade-leave-active {
  transition: opacity .3s ease;
}
.component-fade-enter, .component-fade-leave-to
/* .component-fade-leave-active for <2.1.8 */ {
  opacity: 0;
}
</style>
