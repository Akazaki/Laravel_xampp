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
</style>