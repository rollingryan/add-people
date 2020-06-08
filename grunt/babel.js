module.exports = {
  options: {
    sourceMap: true,
    stage: 0,
  },
  files: {
    expand: true,
    src: ["**/*.es6"],
    ext: "-compiled.js",
  },
};
