const path = require('path');

module.exports = {
    entry: './src/js',
    output: {
        filename: 'main.js',
        path: path.resolve(__dirname, 'web/js'),
    },
    module: {
        loaders: [
            {
                test: /\.jsx?$/,
                loader: 'babel',
                exclude: /node_modules/,
                plugins: ["transform-class-properties"],
                query: {
                    cacheDirectory: true,
                    presets: ['es2015', 'react']
                }
            }
        ]
    }
};