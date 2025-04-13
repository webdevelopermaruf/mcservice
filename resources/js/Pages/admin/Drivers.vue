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
                        <img :src="driver.photo" style="width: 100px" class="rounded object-cover" />
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-400">{{ driver.name }}</h3>
                            <p class="text-sm text-gray-300">{{ driver.email }} | {{ driver.phone }}</p>
                            <p class="text-sm text-gray-300">Fleet: {{ driver.fleet }}</p>
                        </div>
                    </div>
                    <div>
                        <button @click="driver.showDetails = !driver.showDetails" class="text-sm text-yellow-400 hover:underline">
                            {{ driver.showDetails ? 'Hide' : 'Details' }}
                        </button>
                    </div>
                </div>

                <div v-if="driver.showDetails" class="mt-3 text-sm text-gray-200 space-y-1">
                    <p><strong>Address:</strong> {{ driver.address }}</p>
                    <p><strong>Driving License:</strong></p>
                    <img :src="driver.driving_license" style="width: 120px" class="rounded" />
                    <div class="flex space-x-4 mt-2">
                        <button @click="openModal(driver)" class="text-yellow-400 hover:underline">Edit</button>
                        <button @click="deleteDriver(driver.id)" class="text-red-400 hover:underline">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-gray-800 text-white p-6 rounded-lg w-full max-w-3xl relative">
                <h3 class="text-xl font-semibold mb-4">{{ editingDriver.id ? 'Edit Driver' : 'Add Driver' }}</h3>
                <form @submit.prevent="saveDriver" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template v-for="field in fields" :key="field.key">
                            <div>
                                <label class="block mb-1 text-sm">{{ field.label }}</label>
                                <input v-model="editingDriver[field.key]" :type="field.type" class="input" :placeholder="field.label" :required="field.required" />
                            </div>
                        </template>
                        <div>
                            <label class="block mb-1 text-sm">Photo</label>
                            <input type="file" @change="handlePhoto" class="input bg-gray-700 text-white" />
                        </div>
                        <div>
                            <label class="block mb-1 text-sm">Driving License</label>
                            <input type="file" @change="handleLicense" class="input bg-gray-700 text-white" />
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">Cancel</button>
                        <button type="submit" class="px-6 py-2 bg-yellow-500 text-gray-900 font-semibold rounded hover:bg-yellow-400">
                            {{ editingDriver.id ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

const drivers = ref([])
const showModal = ref(false)
const editingDriver = ref({})
const photoFile = ref(null)
const licenseFile = ref(null)

const fields = [
    { key: 'name', label: 'Name', type: 'text', required: true },
    { key: 'email', label: 'Email', type: 'email', required: true },
    { key: 'phone', label: 'Phone', type: 'text', required: true },
    { key: 'address', label: 'Address', type: 'text', required: true },
    { key: 'fleet', label: 'Fleet', type: 'text', required: true },
]

onMounted(fetchDrivers)

function openModal(driver = null) {
    editingDriver.value = driver ? { ...driver } : {}
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    editingDriver.value = {}
    photoFile.value = null
    licenseFile.value = null
}

function handlePhoto(e) {
    photoFile.value = e.target.files[0]
}

function handleLicense(e) {
    licenseFile.value = e.target.files[0]
}

async function fetchDrivers() {
    const res = await fetch('/admin/api/drivers')
    const data = await res.json()
    drivers.value = data.map(d => ({ ...d, showDetails: false }))
}

async function saveDriver() {
    const formData = new FormData()
    for (const key in editingDriver.value) {
        if (editingDriver.value[key]) {
            formData.append(key, editingDriver.value[key])
        }
    }
    if (photoFile.value) formData.append('photo', photoFile.value)
    if (licenseFile.value) formData.append('driving_license', licenseFile.value)

    let url = '/admin/api/drivers'
    let method = editingDriver.value.id ? 'PUT': 'POST'
    if (editingDriver.value.id) {
        formData.append('_method', 'PUT')
        url = `/admin/api/drivers/update/${editingDriver.value.id}`
    }

    const res = await fetch(url, {
        method: method,
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: formData,
    })

    const data = await res.json()
    if (editingDriver.value.id) {
        const index = drivers.value.findIndex(d => d.id === data.id)
        drivers.value[index] = { ...data, showDetails: false }
    } else {
        drivers.value.push({ ...data, showDetails: false })
    }

    closeModal()
}

async function deleteDriver(id) {
    if (!confirm('Are you sure you want to delete this driver?')) return
    await fetch(`/admin/api/drivers/${id}`, { method: 'GET', headers: { 'X-CSRF-TOKEN': csrfToken } })
    drivers.value = drivers.value.filter(d => d.id !== id)
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
