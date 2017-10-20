<template>
	<div>
		<div id="Loading" :class="state" class="overlay">
			<div class="loading"></div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			state: ''
		}
	},
	methods: {
		start() {
			this.state = 'enter'
		},
		end() {
			this.state = 'leave'
			setTimeout(() => {
				this.state = ''
			}, 1400)
		}
	}
}

</script>

<style scoped>
@keyframes router-transition-in {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
.overlay {
  position: absolute;
  background: rgba(220, 220, 220, 0.8);
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 100;
  display: none;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 1s ease .4s;
}
.overlay.enter {
  display: flex;
  opacity: 1;
  animation: router-transition-in 0.4s;
}
.overlay.leave {
  display: flex;
  opacity: 0;
}
</style>