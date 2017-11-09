<template>
	<div id="Datetime">
		<div class="form_field">
			<div class="datetimepicker">
				<el-date-picker v-model="datetime_value" type="datetime" placeholder="日付の選択"></el-date-picker>
			</div>
		</div>
	</div>
</template>

<script>
// import userStore from '../../stores/userStore'

	export default {
		props: ['value'],
		data (){
			return {
				datetime_value: this.value.value,
				key: this.value.key,
			}
		},
		created () {
		},
		watch: {
			datetime_value: function () {
				//変更時、親に渡す
				this.$emit('ValueUpdate', this.datetime_value, this.key)
			}
		},
		methods: {
		}
	}
</script>