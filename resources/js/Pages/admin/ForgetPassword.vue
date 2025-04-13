<script setup>
import {reactive} from 'vue';
const form = reactive({
    step: 0,
    email: null,
    verifyCode: null,
    code: null,
    new_password:"",
    confirm_password:""
})
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

const submit = () =>{
    if(form.step === 1){
        if(form.code === form.verifyCode){
            form.step = 2;
            alert("code matched")
        }else{
            alert("Wrong Code Given")
        }
    }else if(form.step === 0 && form.email !== '') {
        form.step = 1;
        form.code = Math.floor(Math.random() * 1000000);
    }
}
</script>

<template>
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-xl p-8 animate-fadeIn">
        <!-- Logo/Title -->
        <h1 class="text-3xl font-bold text-center text-yellow-400 mb-6">Mash Chauffeur</h1>
        <p class="text-center text-gray-400 mb-8" v-show="form.step === 0">Put your email to reset your password</p>
        <p class="text-center text-gray-400 mb-8" v-show="form.step === 1">
            We have send you a code on {{form.email}}
        </p>

        <!-- Login Form -->
        <form v-if="form.step !== 2" @submit.prevent="submit" method="POST" class="space-y-6" style="min-width: 250px">
            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">
                    {{form.step ? 'Code' : 'Email'}}
                </label>
                <input
                    v-show="form.step===0"
                    type="email"
                    name="email"
                    v-model="form.email"
                    class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                    placeholder="Enter Your Email"
                >
                <input
                    v-show="form.step===1"
                    type="number"
                    name="verify"
                    v-model="form.verifyCode"
                    class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                    placeholder="Submit Code"
                >
            </div>
            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-yellow-500 text-gray-900 py-3 rounded-full hover:bg-yellow-400
                 disabled:bg-yellow-600
                 transition-colors duration-200 font-semibold"
            >
                {{ form.step ? "Submit Code" : "Send Link" }}
            </button>
        </form>
        <div v-else>
            <form action="/admin/change-password" method="POST" class="space-y-6" style="min-width: 250px">
            <!-- Email Field -->
                <input type="hidden" name="_token" :value="csrfToken">
                <input type="hidden" name="email" v-model="form.email">
            <div>
                <label for="new_password" class="block text-sm font-medium text-gray-300">
                    New Password
                </label>
                <input
                    type="password"
                    name="new_password"
                    v-model="form.new_password"
                    class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                    placeholder="Enter Your Email">
            </div>
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-gray-300">
                    Confirm Password
                </label>
                <input
                    type="password"
                    name="confirm_password"
                    v-model="form.confirm_password"
                    class="mt-1 w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition-colors duration-200"
                    placeholder="Enter Your Email">
            </div>
            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-yellow-500 text-gray-900 py-3 rounded-full hover:bg-yellow-400
                 disabled:bg-yellow-600
                 transition-colors duration-200 font-semibold"
            >
                Change Password
            </button>
        </form>
        </div>
    </div>
</template>

<style scoped>

</style>
