<template>
	<div id="RichText">
		<div class="form_field">
			<div id="editor">
			    <textarea class="editor" v-model="markdown_value"></textarea>
					<vue-markdown :source="markdown_value"></vue-markdown>
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
		data (){
			return {
				markdown_value: '# hello\n:smile:',
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