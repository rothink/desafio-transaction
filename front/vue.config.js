var path = require('path');
module.exports = {
	transpileDependencies: [/node_modules[/\\\\]vuetify[/\\\\]/],
	lintOnSave: false,
	configureWebpack: {
		resolve: {
			alias: {
				'~': path.join(__dirname, './src'),
				$components: path.join(__dirname, './src/components'),
				$pages: path.join(__dirname, './src/pages'),
				$services: path.join(__dirname, './src/services'),
				$layouts: path.join(__dirname, './src/layouts'),
				$api: path.join(__dirname, './src/api'),
			},
		},
	},
};
