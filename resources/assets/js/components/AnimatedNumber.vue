<template>
  <span>{{ parseInt(tweeningValue) | moneymoney }}</span>
</template>

<script>
import Helpers from './Helpers'
import TWEEN from '@tweenjs/tween.js'

export default {
  name: 'Animatednumber',
  mixins: [Helpers],
  props: {
    value: {
      type: Number,
      required: true
    }
  },
  data () {
    return {
      tweeningValue: 0
    }
  },
  watch: {
    value: function (newValue, oldValue) {
    this.tween(oldValue, newValue)
    }
  },
  mounted: function () {
    this.tween(0, this.value)
  },
  methods: {
    tween: function (startValue, endValue) {
    var vm = this
    var animationFrame
    function animate (time) {
      TWEEN.update(time)
      animationFrame = requestAnimationFrame(animate)
    }
    new TWEEN.Tween({ tweeningValue: startValue })
      .to({ tweeningValue: endValue }, 500)
      .onUpdate(function () {
      vm.tweeningValue = this.tweeningValue.toFixed(0)
      })
      .onComplete(function () {
      cancelAnimationFrame(animationFrame)
      })
      .start()
    animationFrame = requestAnimationFrame(animate)
    }
  }
}
</script>
