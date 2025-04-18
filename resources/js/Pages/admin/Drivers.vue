<template>
    <div class="p-6 text-white">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-yellow-400">Drivers</h2>
            <button @click="openModal()" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-semibold">
                + Add Driver
            </button>
        </div>

        <div class="space-y-4">
            <div v-for="driver in drivers" :key="driver.id" class="bg-gray-800 rounded-lg p-4 shadow">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <img :src="driver.photo" style="max-width: 120px" class="rounded object-cover" />
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-400">{{ driver.name }}</h3>
                            <p class="text-sm text-gray-300">Phone: {{ driver.phone }}</p>
                            <p class="text-sm text-gray-300">Email: {{ driver.email }}</p>
                        </div>
                    </div>
                    <div>
                        <button @click="driver.showDetails = !driver.showDetails" class="text-sm text-yellow-400 hover:underline">
                            {{ driver.showDetails ? 'Hide' : 'Details' }}
                        </button>
                    </div>
                </div>

                <div v-if="driver.showDetails" class="mt-3 text-sm flex flex-wrap text-gray-200 space-y-1">
                    <div>
                        <p><strong>Address:</strong> {{ driver.address }}</p>
                        <p><strong>Fleet:</strong> {{ driver.fleet }}</p>
                    </div>
                    <img style="max-width: 50%" :src="driver.driving_license">
                    <div class="flex w-full space-x-3 mt-2">
                        <button @click="openModal(driver)" class="text-yellow-400 hover:underline">Edit</button>
                        <form :action="`/admin/api/drivers/${driver.id}`" method="POST" class="inline">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" :value="csrfToken">
                            <button type="submit" class="text-red-400 hover:underline">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-gray-800 text-white p-6 rounded-lg w-full max-w-3xl relative">
                <h3 class="text-xl font-semibold mb-4">{{ editingDriver.id ? 'Edit Driver' : 'Add Driver' }}</h3>
                <div class="overflow-y-auto max-h-[calc(100vh-120px)]">
                    <form :action="editingDriver.id ? `/admin/api/drivers/${editingDriver.id}` : '/admin/api/drivers'" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <template v-for="field in fields" :key="field.key">
                                <div>
                                    <label class="block mb-1 text-sm">{{ field.label }}</label>
                                    <input v-model="editingDriver[field.key]" :type="field.type" :placeholder="field.label" class="input" :required="field.required" :name="field.key" />
                                </div>
                            </template>
                            <div>
                                <label class="block mb-1 text-sm">Image</label>
                                <input type="file" class="input bg-gray-700 text-white" name="photo" />
                            </div>
                            <div>
                                <label class="block mb-1 text-sm">Driving License</label>
                                <input type="file" class="input bg-gray-700 text-white" name="driving_license" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-4 space-x-3">
                            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-yellow-500 text-gray-900 font-semibold rounded hover:bg-yellow-400">
                                {{ editingDriver.id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

const drivers = ref([])
const showModal = ref(false)
const editingDriver = ref({})
const fields = [
    { key: 'name', label: 'Name', type: 'text', required: true },
    { key: 'email', label: 'Email', type: 'email', required: true },
    { key: 'phone', label: 'Phone', type: 'text', required: true },
    { key: 'address', label: 'Address', type: 'text', required: true },
    { key: 'fleet', label: 'Fleet', type: 'text', required: false },
]

onMounted(fetchDrivers)

function openModal(driver = null) {
    editingDriver.value = driver ? { ...driver } : {}
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    editingDriver.value = {}
}

async function fetchDrivers() {
    const res = await fetch('/admin/api/drivers')
    const data = await res.json()
    drivers.value = data.map(d => ({ ...d, showDetails: false }))
}
</script>

<style scoped>
.input {
    width: 100%;
    padding: 0.75rem;
    background-color: #2d2d2d;
    border: 1px solid #444;
    border-radius: 0.375rem;
    color: white;
}
.input:focus {
    outline: none;
    border-color: #fbbf24;
}
</style>
