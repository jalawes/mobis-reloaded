<template>
  <canvas class="matrix" id="mobis-matrix" width="600" height="300"></canvas>
</template>

<script>
  export default {
    name:     'Matrix',
    computed: {
      canvas () {
        return document.getElementById('mobis-matrix')
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
    methods:  {
      matrixSupport (canvas) {
        return !!canvas.getContext
      },
      matrixApp () {
        if (!this.matrixSupport(this.canvas)) {
          return
        }
        this.runMatrix()
        this.drawScreen()
      },
      runMatrix () {
        if (typeof Game_Interval != 'undefined') clearInterval(Game_interval)
        let Game_Interval = setInterval(this.drawScreen, 50)
      },
      drawScreen () {
        this.ctx.fillStyle = 'rgba(0,0,0,.05)'
        this.ctx.fillRect(0, 0, this.w, this.h)
        this.ctx.fillStyle = '#0f0'
        this.ctx.font      = '10px Georgia'
        this.yPositions.map((y, index) => {
//         let letters = ['t','h','e',' ', 'm','o','b','i','s',' ','r','e','o','a','d','e','d', ' ']
//         let text = letters[Math.floor(Math.random() * letters.length)]
          let text = String.fromCharCode(1e2 + Math.random() * 50)
          let x    = (index * 10) + 10
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
      this.matrixApp()
    }
  }
</script>

<style scoped>
  .matrix {
    position: absolute;
    z-index: -1;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: flex-start;
  }
</style>
