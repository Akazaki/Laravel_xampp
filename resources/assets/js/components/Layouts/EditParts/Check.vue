<template>
	<div id="Check">
		<div class="form_field">
			<ul>
				<template v-for="(value, key) in checkbox_master">
					<li>
						<!-- <template v-if="(1 << (key-1) & checkbox_num)">
							<input v-model="checked_names" type="checkbox" :checked="true" v-bind:id="'checkid'+key" v-bind:value="key"/>
						</template>
						<template v-else>
							<input v-model="checked_names" type="checkbox" :checked="true" v-bind:id="'checkid'+key" v-bind:value="key"/>
						</template> -->
						<template>
							<input v-model="checked_names" type="checkbox" :checked="true" v-bind:id="'checkid'+key" v-bind:value="key"/>
						</template>

						<label v-bind:for="'checkid'+key">{{value}}</label>
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
				checkbox_master: {},
				checked_names: [],
				checkbox_num: this.value.value,
				key: this.value.key,
			}
		},
		created () {
			this.get_master(this.value.key);
		},
		watch: {
			checked_names: function () {
				//変更時、親に渡す
				this.$emit('ValueUpdate', this.checked_names, this.key)
			}
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
						this.checkbox_master = res.data;
						var self = this;

						// チェック判定
						for (var i = 0; i < Object.keys(this.checkbox_master).length; i++) {
							// 2進数判定
							if((1 << (i) & self.checkbox_num)){
								var key_num = i+1;
								self.checked_names[i] = String(key_num);
							}
						}
						
						this.$emit('ValueUpdate', this.checked_names, this.key)
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