import Vue from 'vue/dist/vue.js';
import AsyncComputed from 'vue-async-computed';
const Percentages = require('../source/js/Percentages');

Vue.use(AsyncComputed);

new Vue({
	el: '#example',
	data: {
		options: [
			{	name: 'React',      votes: 21 },
			{	name: 'Vue',        votes: 13 },
			{	name: 'Svelte',     votes: 0  },
			{	name: 'jQuery',     votes: 4  },
			{	name: 'Vanilla JS', votes: 1  },
		],
		useJS: false,
	},
	computed: {
		// Copy votes from all options into a new array for use with the Percentages class.
		votes: function() {
			return this.options.map((object) => {
				return object.votes;
			});
		},
	},
	asyncComputed: {
		// Calculate percentage values based on computed `votes` array.
		percentages: function() {
			return !this.useJS
				? fetch(`/example/fetch/?votes=[${this.votes}]`).then(response => response.json())
				: new Percentages(this.votes);
		}
	},
	methods: {
		// Calculate the sum of values for a given property in all objects from an array.
		sum: function(array, objProp) {
			return array.reduce((accumulator, object) => {
				return accumulator + object[objProp];
			}, 0);
		},
		// Cast a vote on any of the options.
		// Switch to JS values if not done already.
		vote: function(option) {
			if(!this.useJS) this.useJS = true;
			option.votes++;
		}
	}
});
