module.exports = {
  extends: ["plugin:vue/vue3-essential", "eslint:recommended"],
  rules: {
    "no-console": process.env.NODE_ENV === "production" ? "warn" : "off",
    "no-debugger": process.env.NODE_ENV === "production" ? "warn" : "off",
  },
  env: {
    node: true,
    browser: true
  },
  globals: {
    process: true
  },
};
