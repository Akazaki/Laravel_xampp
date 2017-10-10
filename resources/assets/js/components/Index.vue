<template>
	<div>
		{{ userState.user.name }}
		<router-link to="about">about</router-link>
		<router-link to="wow/login">login</router-link>
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