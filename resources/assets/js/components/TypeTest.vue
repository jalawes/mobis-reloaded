<template>
  <div class="section">
    <p>
      <strong>Status</strong>:
      <span :class="[{ 'is-success': !loading }]">{{ feedback }}</span>
    </p><br>
    <div class="box">
      <div v-show="!loading">
        <div class="content is-large">
          <p><strong>{{ typingtest.title }}</strong></p>
          <p class="is-unselectable">{{ typingtest.text }}</p>
        </div>
      </div>
    </div>
    <div class="field">
      <p class="control">
        <input
          @keydown="usertyped"
          type="text"
          class="input is-large"
          placeholder="Type the above text here to start"
          v-model="userinput"
        >
      </p>
      <p>{{ userinput }}</p>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Typetypingtest',
    props: {
        //
    },
    data () {
      return {
        typingtest: [],
        loading: false,
        feedback: '',
        wpm: 0,
        goal: 100,
        userinput: '',
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
      usertyped () {
        console.log(event.key)
      }
    },
    computed: {
        //
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
</style>
