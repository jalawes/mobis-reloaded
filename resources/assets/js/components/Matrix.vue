<template>
  <canvas class="matrix" id="myCanvas" width="600" height="300"></canvas>
</template>

<script>
export default {
  name: 'Matrix',
  computed: {
    canvas () {
      return document.getElementById('myCanvas')
    },
    ctx () {
      return this.canvas.getContext('2d')
    },
    w () {
      return this.canvas.width = window.innerWidth
    },
    h () {
      return this.canvas.height = window.innerHeight
    },
    yPositions () {
      return Array(300).join(0).split('')
    }
  },
  methods: {
    canvasSupport (canvas) {
      return !!canvas.getContext
    },
    canvasApp () {
      if (!this.canvasSupport(this.canvas)) {
        return
      }
      this.runMatrix()
      this.drawScreen()
    },
    runMatrix () {
      if (typeof Game_Interval != 'undefined') clearInterval(Game_interval)
      let Game_Interval = setInterval(this.drawScreen, 33)
    },
    drawScreen () {
      this.ctx.fillStyle = 'rgba(0,0,0,.05)'
      this.ctx.fillRect(0, 0, this.w, this.h)
      this.ctx.fillStyle = '#0f0'
      this.ctx.font = '10px Georgia'
      this.yPositions.map((y, index) => {
        let text = String.fromCharCode(1e2 + Math.random() * 33)
        let x = (index * 10) + 10
        this.ctx.fillText(text, x, y)
        if (y > 100 + Math.random() * 1e4) {
          this.yPositions[index] = 0
        } else {
          this.yPositions[index] = y + 10
        }
      })
    }
  },
  mounted () {
    console.log('loaded and ready!')
    this.canvasApp()
  }
}
</script>

<style scoped>
.matrix {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}
</style>
