<template>
	<div id="RichText">
		<div class="form_field">
			<div id="editor">
			    <textarea class="editor" v-model="markdown_value"></textarea>
				<div class="view-area">
					<vue-markdown :source="markdown_value"></vue-markdown>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import locale from 'element-ui/lib/locale/lang/ja'
import VueMarkdown from 'vue-markdown'

	export default {
		props: ['value'],
		data (){
			return {
				markdown_value: this.value.value,
				key: this.value.key,
			}
		},
	    filters: {
	        marked: marked
	    },
		created () {

		},
		computed: {
			compiledMarkdown: function () {
				return marked(this.input, { sanitize: true })
			}
		},
		watch: {
			markdown_value: function () {
				this.$emit('ValueUpdate', this.markdown_value, this.key)
			}
		},
		//markdown
		update: _.debounce(function (e) {
			this.input = e.target.value
		}, 300),
		methods: {
		},
		components: {
			VueMarkdown
		}
	}
</script>