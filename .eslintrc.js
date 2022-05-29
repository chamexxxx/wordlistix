module.exports = {
  env: {
    browser: true,
    es2021: true,
    'vue/setup-compiler-macros': true,
  },
  extends: [
    'plugin:vue/vue3-essential',
    'airbnb-base',
  ],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
  },
  plugins: [
    'vue',
  ],
  ignorePatterns: ['webpack.config.js'],
  rules: {
    'vue/multi-word-component-names': 0,
    'import/no-unresolved': 0,
  },
};
