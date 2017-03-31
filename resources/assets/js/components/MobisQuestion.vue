<template>
<transition name="component-fade" mode="out-in">

    <div class="media-left">
      <figure class="image is-64x64" >
          <img :src="'/' + currentQuestion.subject + '.png'" alt="Image">
      </figure>
    </div>

    <transition name="component-fade" mode="out-in" appear>
      <div class="media-content">
        <div class="content">
          <p>
            <strong>Question {{ questions.length }}:</strong>
            <small>{{ quiz.currentQuestion.creator }}</small>
            <small>{{ quiz.currentQuestion.created_at }}</small>
            <br>
            {{ quiz.currentQuestion.problem }}
          </p>
        </div>
      </div>
    </transition>
</transition>
</template>

<script>
export default {
    name: 'Question',
    props: {
        currentQuestion: {
            type: Object,
            required: true
        }
    }
}
</script>

<style>
/* */
</style>
