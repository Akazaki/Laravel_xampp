<template>
	<div id="Radio">
		<div class="form_field">
			<ul>
				<template v-for="(value, key) in radiobutton_master">
					<li>
						<template v-if="radiobutton_num == key">
							<input type="radio" name="radio" v-model="radiobutton_num" v-bind:id="'radioid' + key" v-bind:value="key" checked="checked"/>
							<label v-bind:for="'radioid' + key">{{value}}</label>
						</template>
						<template v-else>
							<input type="radio" name="radio" v-model="radiobutton_num" v-bind:id="'radioid' + key" v-bind:value="key" />
							<label v-bind:for="'radioid' + key">{{value}}</label>
						</template>
					</li>
				</template>
			</ul>
		</div>
	</div>
</template>

<script>
	export default {
		props: [
			'value',
		],
		data (){
			return {
				radiobutton_master: {},
				radiobutton_num: Number(this.value.value),
				key: this.value.key,
			}
		},
		created () {
			this.get_master(this.value.key);
		},
		watch: {
			radiobutton_num: function () {
				this.$emit('ValueUpdate', Number(this.radiobutton_num), this.key)
			}
		},
		computed: {
		},
		methods: {
			/**
			 * マスターデータ取得
			 * @param {table_name} stirng - テーブル名
			 */
			get_master(table_name){
				axios.post('/api/wow/getMasterData', {table_name: table_name})
				.then(res => {
					if(res.data && res.status == 200){
						this.radiobutton_master = res.data;
					}else{
						this.$router.push('/wow/login')
					}
					
				}).catch(error => {
					this.$router.push('/wow/login')
				});
			},
		},
	}
</script>