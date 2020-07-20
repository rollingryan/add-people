const path = require("path");

module.exports = {
  mode: "production",
  entry: "./client/js/dev/frontend.js",
  output: {
    filename: "frontend.min.js",
    path: path.resolve(__dirname, "client/js/prod"),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
      {
        test: /\.css$/,
        loader: "style-loader",
      },
      {
        test: /\.css$/,
        loader: "css-loader",
        options: {
          minimize: true,
        },
      },
    ],
  },
};
