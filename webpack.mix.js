const mix = require('laravel-mix');
const path = require('path');

require('mix-tailwindcss');
require('laravel-mix-clean');
require('laravel-mix-copy-watched');


mix.disableNotifications();
mix.setPublicPath('public/assets/');

mix.options({
		processCssUrls: false
	})
	.alias({
		'@': path.join(__dirname, 'resources/admin/js'),
		'@@': path.join(__dirname, 'resources/js')
	});

let hasFlag = process.env.npm_config_front ||  process.env.npm_config_back;

if (process.env.npm_config_back || !hasFlag) {
	mix.js('resources/admin/js/app.js', 'admin/js').vue()
		.sass('resources/admin/sass/app.sass', 'admin/css')
		.tailwind();
	mix.copyDirectoryWatched('resources/admin/images/**/*.*', 'public/assets/admin/images/', {base: 'resources/admin/images'});
}

if (process.env.npm_config_front || !hasFlag) {
	mix.js('resources/assets/js/app.js', 'js').vue()
	mix.sass('resources/assets/sass/style.sass', 'css')
	mix.js('resources/assets/js/gallery.js', 'js')
	mix.copyWatched('resources/assets/images/**/*.*', 'public/assets/images/', {base: 'resources/assets/images'});
}

if (!hasFlag)
	mix.clean();


if (mix.inProduction()) {
	mix.version()
} else {
	mix.sourceMaps(false, 'source-map');

	mix.browserSync({
		proxy: process.env.APP_URL,
		open: false,
		files: [
			'app/**/*.php',
			'config/*.php',
			'routes/**/*.php',
			'resources/views/**/*.php',
			'public/**/css/*.css',
			'public/**/js/*.js',
			'public/**/images/*.*',
		]
	})
}
