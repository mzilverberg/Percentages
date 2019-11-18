import Vue from 'vue/dist/vue.js';
const Percentages = require('../source/js/Percentages');

new Vue({
	el: '#example',
	data: {
		// Options are set in the `beforeMount` hook.
		options: []
	},
	computed: {
		// Copy votes from all options into a new array for use with the Percentages class.
		votes: function() {
			return this.options.map((object) => {
				return object.votes;
			});
		},
		// Calculate percentage values based on computed `votes` array.
		percentages: function() {
			return new Percentages(this.votes);
		}
	},
	methods: {
		// Switch from server-side to client-side handling. Immediately cast a vote, too.
		// This function is called once at most, since it is bound to `v-on:click.once`
		switchToJS: function(index) {
			// Toggle visibility of table rows and footer cells.
			const visible = this.$el.querySelectorAll('.visible');
			const hidden = this.$el.querySelectorAll('.hidden');
			visible.forEach((el) => {
				el.classList.remove('visible');
				el.classList.add('hidden');
			});
			hidden.forEach((el) => {
				el.classList.remove('hidden');
			});
			// Automatically cast a vote on the correct option
			this.vote(this.options[index]);
		},
		// Calculate the sum of values for a given property in all objects from an array.
		sum: function(array, objProp) {
			return array.reduce((accumulator, object) => {
				return accumulator + object[objProp];
			}, 0);
		},
		// Cast a vote on any of the options.
		vote: function(option) {
			option.votes++;
		}
	},
	beforeMount: function() {
		// Before mounting, retrieve example options from `data-options` attribute.
		const tbody = this.$el.getElementsByTagName('tbody')[0];
		this.options = JSON.parse( tbody.dataset['options'] )
	}
});
