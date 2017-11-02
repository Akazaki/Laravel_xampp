<template>
	<div id="Radio">
		<div class="form_field">
			<ul>
				<li>
					<input type="radio" name="radio" v-bind:id="'radioid' + 1" />
					<label v-bind:for="'radioid' + 1">ssssssssssssssss</label>
				</li>
				<li>	
					<input type="radio" name="radio" v-bind:id="'radioid' + 2" />
					<label v-bind:for="'radioid' + 2">ssssssssssssssss</label>
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