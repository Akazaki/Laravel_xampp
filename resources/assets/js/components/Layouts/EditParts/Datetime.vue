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
		data (){
			return {
				datetime_value: '',
			}
		},
		created () {
		},
		methods: {
		}
	}
</script>