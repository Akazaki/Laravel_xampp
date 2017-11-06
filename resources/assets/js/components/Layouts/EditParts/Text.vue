<template>
	<div id="Text">
		<div class="form_field">
			<input type="text" name="name" class="form__input" placeholder="text" v-model="text_value" required>
		</div>
	</div>
</template>

<script>

	export default {
		props: ['value'],
		data (){
			return {
				text_value: this.value.value,
				key: this.value.key,
			}
		},
		updated (){
			//変更時、親に渡す
			this.$emit('ValueUpdate', this.text_value, this.key)
		},
		created () {
		},
		methods: {
		}
	}
</script>