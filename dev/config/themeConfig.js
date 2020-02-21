"use strict";

module.exports = {
	theme: {
		slug: "xten",
		name: "XTen",
		author: "Ricky Adams"
	},
	dev: {
		browserSync: {
			live: true,
			proxyURL: "xten-lt-253728:8888/xten-blocks",
			bypassPort: "9999"
		},
		browserslist: [
			// See https://github.com/browserslist/browserslist
			"> 1%",
			"last 3 versions",
			"Firefox >= 20",
			"iOS >=7"
		],
		debug: {
			styles: false, // Render verbose CSS for debugging.
			scripts: false // Render verbose JS for debugging.
		}
	},
	export: {
		compress: true
	}
};
