<template>
<div class="content">
  <div>
    <p><strong>Status</strong>: <span :class="[{ 'is-success': !loading }]">{{ feedback }}</span></p>
    <progress
      class="progress is-success is-small"
      :max="timerMax"
      :value="timer">
      {{ timer }}
    </progress>
    <div class="box">
      <div class="inner-box">
        <div v-show="!loading">
          <p>{{ currentQuestion }}</p>
        </div>
      </div>
    </div>
    <nav class="level">
      <div
        class="level-item has-text-centered"
        v-for="(answer, index) in answers"
      >
        <div>
          <p class="heading">
            <a :class="[{'is-loading': loading}, {'is-disabled': !currentQuestion}, 'button is-outlined']"
              @click="inputAnswer(index)">
              {{ answer }}
            </a>
          </p>
        </div>
      </div>
    </nav>

    <div class="level">
        <div class="level-left"></div>
        <div class="level-right bottom-menu">
          <span class="nav-item">
            <p class="level-item">
              <a :class="[{'is-loading': loading}, {'is-disabled': currentQuestion}, ' button is-outlined']"
                @click="getAnswer">
                Play
              </a>
              <a :class="[{'is-disabled': !loading && !currentQuestion}, 'button is-outlined']"
                @click="reset">
                Reset
              </a>
            </p>
          </span>
        </div>
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
      currentQuestion: null,
      userAnswer: '',
      answers: {
        A: 'answer',
        B: 'answer',
        C: 'answer',
        D: 'answer',
      },
      timer: 0,
      timerMax: 30,
      feedback: 'Ready to start',
    }
  },
  methods: {
    reset () {
      this.loading = true
      this.timer = this.timerMax
      this.questionHistory = []
      this.currentQuestion = null
      this.loading = false
      this.feedback = 'Ready to start'
    },
    getAnswer: _.debounce(
      function () {
        this.feedback = 'Thinking...'
        this.getQuiz()
      }
    ),
    getQuiz () {
      this.loading = true
      this.currentQuestion = {}
      axios.get('/api/quiz')
        .then(response => {
          this.questionHistory.push(response.data)
          this.loading = false
          this.feedback = 'Waiting for user...'
          this.timer = this.timerMax
          this.startTimer()
        })
        .then(this.viewCurrentProblem) // load next problem into dom
        .catch(errors => console.log(errors))
    },
    inputAnswer (answer) {
      this.loading = true
      console.log('answered', answer)
      this.getQuiz()
    },
    startTimer () {
      let vm = this
      setTimeout(() => {
        if (vm.timer <= 0 || vm.loading == true) {
          vm.feedback = 'Failed to answer'
          vm.reset()
        }
        if (!vm.currentQuestion) { // stop timer if no question loaded
          vm.reset()
        } else {
          vm.timer = vm.timer - 0.01
          vm.startTimer()
        }
      }, 10)
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
