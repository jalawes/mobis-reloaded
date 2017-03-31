<template>
<transition name="component-fade" mode="out-in" appear>
  <div class="media-content">
    <div class="content">
        <p>
        <strong>Question 123:</strong>
        <small>{{ currentQuestion.creator }}</small>
        <small>{{ currentQuestion.created_at }}</small>
        <br>
        {{ quiz.currentQuestion.problem }}
        </p>
    </div>
  </div>
</transition>
</template>

<script>
export default {
  name: 'HUD',
  props: {
    //
  }
}
</script>
