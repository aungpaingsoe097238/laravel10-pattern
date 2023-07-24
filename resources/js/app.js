import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import routes from "./routes"; // Assuming you named the file as routes.js
import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(App);
app.use(router); // Add the router to the Vue app
app.mount("#app");
