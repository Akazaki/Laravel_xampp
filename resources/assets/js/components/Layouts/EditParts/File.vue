<template>
	<div id="File">
		<div class="form_field">
			<div class="fileup_field">
				<template v-if="!image">
					<input type="file" v-on:change="onFileChange" name="file" id="file" class="input-file">
					<label for="file" class="btn btn-tertiary js-labelFile">
						<i class="icon fa fa-check"></i>
					</label>
				</template>
				<template v-else>
					<div class="button_green">
						<a href="javascript:void(0);" v-on:click="removeImage">Remove</a>
					</div>
					<img :src="image" />
				</template>
			</div>
		</div>
	</div>
</template>

<script>

	export default {
		props: ['value'],
		data (){
			return {
				image: this.value.value,
				key: this.value.key,
			}
		},
		created () {
		},
		updated (){
			//変更時、親に渡す
			this.$emit('ValueUpdate', this.image, this.key)
		},
		methods: {
			//fileup
			onFileChange(e) {
				var files = e.target.files || e.dataTransfer.files;
				if (!files.length)
				return;
				this.createImage(files[0]);
			},
			createImage(file) {

				// FormData を利用して File を POST する
                let formData = new FormData();
                formData.append('image', file);
                let config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                axios.post('/api/wow/fileup', formData, config)
                .then(res => {
                	// response 処理
                	var img_path = '/public/wow/tmpfile/'+res.data.img_name;
                	this.image = img_path;
                }).catch(error => {
                    // error 処理
                    console.log(error)
                })
			},
			removeImage: function (e) {
				this.image = '';
			}
		}
	}
</script>