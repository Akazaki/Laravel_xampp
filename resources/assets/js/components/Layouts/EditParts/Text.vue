<template>
	<div id="Text">
		<div class="form_field">
			<input type="text" name="name" class="form__input" placeholder="text" v-model="value" required>
		</div>
	</div>
</template>

<script>

	export default {
		props: ['value'],
		data (){
			return {
			}
		},
		created () {
		},
		methods: {
		}
	}
</script>