<script setup>
import { ref } from "vue";
const subMenus = ref([]);

const menus = ref([
    {
        title: "Posts",
        subMenus: [
            { method: "GET", name: "Get All Posts" },
            { method: "GET", name: "Get Single Post" },
            { method: "POST", name: "New Post" },
            { method: "PUT", name: "Update Post" },
            { method: "DELETE", name: "Delete Post" },
        ],
    },
    {
        title: "Categories",
        subMenus: [
            { method: "GET", name: "Get All Posts" },
            { method: "GET", name: "Get Single Post" },
            { method: "POST", name: "New Post" },
            { method: "PUT", name: "Update Post" },
            { method: "DELETE", name: "Delete Post" },
        ],
    },
]);

const handleOpenSubMenus = (index) => {
    const isHidden = subMenus.value[index].classList.contains("hidden");
    if (!isHidden) {
        subMenus.value[index].classList = "hidden";
    } else {
        subMenus.value[index].classList = "block";
    }
};

const handleShowDetail = (subMenu) => {
    console.log(subMenu);
};
</script>

<template>
    <div class="text-slate-800 bg-slate-100">
        <div class="flex">
            <div class="w-[20%] overflow-y-auto fixed top-0 h-screen">
                <ul>
                    <li v-for="(menu, index) in menus" :key="index">
                        <div
                            class="hover:bg-slate-200 rounded-md cursor-pointer p-2 text-md font-medium"
                            @click="handleOpenSubMenus(index)"
                        >
                            {{ menu.title }}
                        </div>
                        <div ref="subMenus" class="hidden">
                            <ul>
                                <li
                                    v-for="(subMenu, index) in menu.subMenus"
                                    :key="index"
                                    class="text-slate-600 py-2 ps-3 hover:ms-2 text-sm cursor-pointer hover:bg-slate-200 rounded-md"
                                    @click="handleShowDetail(subMenu)"
                                >
                                    <span
                                        class="text-xs bg-blue-500 p-1 rounded-lg me-2 text-white"
                                        >{{ subMenu.method }}</span
                                    >
                                    <span>{{ subMenu.name }}</span>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="w-[80%] h-screen ms-[20%]"></div>
        </div>
    </div>
    <router-view></router-view>
</template>
