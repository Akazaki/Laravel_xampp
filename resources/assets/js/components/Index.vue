<template>
	<div>
		<div v-for="article in articles">
			<h1>
				<router-link :to="'/articles/' + article.id">{{ article.title }}</router-link>
			</h1>
			<p>
				{{ article.content }}
			</p>
		</div>
	</div>
</template>

<script>
	import userStore from '../stores/userStore'
	export default {
		created() {
			this.fetchArticles()
		},
		data() {
			return {
				articles: []
			}
		},
		methods: {
			fetchArticles() {
				axios.post('/api/wow')
				.then(res =>  {
					this.articles = res.data
				})
			}
		}
	}
</script>