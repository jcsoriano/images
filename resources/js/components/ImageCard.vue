<template>
	<div class="card">
	  <div class="card-image">
		<figure class="image is-4by3">
		  <img :src="getUrl(image.photo)" alt="Placeholder image">
		</figure>
	  </div>
	  <div class="card-content">
		<div class="content">
			<b-field>
				<b-taginput
					field="name.en"
					v-model="image.tags"
					icon="label"
					placeholder="Add a tag">
				</b-taginput>
			</b-field>
			<div class="has-text-right">
				<a class="button is-info" @click="updateImage">Save</a>
			</div>
		</div>
	  </div>
	  <b-loading :is-full-page="true" :active.sync="isLoading" :can-cancel="false"></b-loading>
	</div>
</template>

<script>
	export default {
		props: {
			image: {
				type: Object,
				required: true,
			}
		},

		data () {
			return {
				isLoading: false,
			}
		},

		methods: {
			getUrl (value) {
				return url(value);
			},

			updateImage () {
				if (this.isLoading) {
					return
				}

				this.isLoading = true

				axios.put(url('images/' + this.image.id), {
					tags: this.image.tags
				}).then((response) => {
					if (response.data.status == 'success') {
						this.isLoading = false
					}
				}).catch((error) => {
					this.isLoading = false
				})
			}
		}
	}
</script>