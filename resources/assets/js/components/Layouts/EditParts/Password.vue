<template>
	<div id="Password">
		<div class="form_field">
			<input type="password" name="password" class="form__input" v-model="password_value" required>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['value'],
		data (){
			return {
				password_value: '',
				key: this.value.key,
			}
		},
		watch: {
			password_value: function () {
				this.$emit('ValueUpdate', this.password_value, this.key);
			},
		},
		created () {
			this.password_value = '';
			this.$emit('ValueUpdate', this.password_value, this.key);
		},
		methods: {
		}
	}
</script>