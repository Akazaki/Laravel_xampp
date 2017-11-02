<template>
	<div id="Check">
		<div class="form_field">
			<ul>
				<li>
					<input type="checkbox" v-bind:id="'checkid' + 1" />
					<label v-bind:for="'checkid' + 1">ssssssssssssssss</label>
				</li>
				<li>
					<input type="checkbox" v-bind:id="'checkid' + 2" />
					<label v-bind:for="'checkid' + 2">ssssssssssssssss</label>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		data (){
			return {
			}
		},
		created () {
		},
		computed: {
		},
		methods: {
		},
	}
</script>