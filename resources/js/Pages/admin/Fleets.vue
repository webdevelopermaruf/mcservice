<template>
    <div class="p-6 text-white">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-yellow-400">Fleets</h2>
            <button @click="openModal()" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-semibold">
                + Add Fleet
            </button>
        </div>

        <div class="space-y-4">
            <div v-for="fleet in fleets" :key="fleet.id" class="bg-gray-800 rounded-lg p-4 shadow">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <img :src="fleet.image" style="max-width: 120px" class="rounded object-cover" />
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-400">{{ fleet.name }}</h3>
                            <p class="text-sm text-gray-300">{{ fleet.description }}</p>
                        </div>
                    </div>
                    <div>
                        <button @click="fleet.showDetails = !fleet.showDetails" class="text-sm text-yellow-400 hover:underline">
                            {{ fleet.showDetails ? 'Hide' : 'Details' }}
                        </button>
                    </div>
                </div>

                <div v-if="fleet.showDetails" class="mt-3 text-sm flex justify-evenly flex-wrap text-gray-200 space-y-1">
                    <div>
                        <p><strong>Passengers:</strong> {{ fleet.passengers }}</p>
                        <p><strong>Luggages:</strong> {{ fleet.luggages }}</p>
                        <p><strong>Min Pay:</strong> £{{ fleet.min_pay }}</p>
                        <p><strong>Min Distances:</strong> {{ fleet.min_distances }} miles</p>
                        <p><strong>After Min:</strong> £{{ fleet.after_min }}/mile</p>
                    </div>
                    <div>
                        <p><strong>Airport Charge:</strong> £{{ fleet.airport_charge }}</p>
                        <p><strong>Min Hours:</strong> {{ fleet.min_hours }}h</p>
                        <p><strong>Min Hours Pay:</strong> £{{ fleet.min_hours_pay }}</p>
                        <p><strong>After Min Hours:</strong> £{{ fleet.after_min_hours }}/hr</p>
                    </div>
                    <div class="flex w-full space-x-3 mt-2">
                        <button @click="openModal(fleet)" class="text-yellow-400 hover:underline">Edit</button>
                        <form :action="`/admin/api/fleets/${fleet.id}`"
                              @submit.prevent="handleDelete"
                              method="POST" class="inline">
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
                <h3 class="text-xl font-semibold mb-4">{{ editingFleet.id ? 'Edit Fleet' : 'Add Fleet' }}</h3>
                <div class="overflow-y-auto max-h-[calc(100vh-120px)]">
                    <form :action="editingFleet.id ? `/admin/api/fleets/${editingFleet.id}` : '/admin/api/fleets'" method="POST" enctype="multipart/form-data" class="space-y-4">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <template v-for="field in fields" :key="field.key">
                                <div>
                                    <label class="block mb-1 text-sm">{{ field.label }}</label>
                                    <input v-model="editingFleet[field.key]" :type="field.type" :placeholder="field.label" class="input" :required="field.required" :name="field.key" />
                                </div>
                            </template>
                            <div>
                                <label class="block mb-1 text-sm">Image</label>
                                <input type="file" class="input bg-gray-700 text-white" name="image" />
                            </div>
                        </div>
                        <div class="flex justify-end mt-4 space-x-3">
                            <button type="button" @click="closeModal" class="px-4 py-2 bg-gray-600 rounded hover:bg-gray-500">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-yellow-500 text-gray-900 font-semibold rounded hover:bg-yellow-400">
                                {{ editingFleet.id ? 'Update' : 'Create' }}
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

const fleets = ref([])
const showModal = ref(false)
const editingFleet = ref({})
const fields = [
    { key: 'name', label: 'Name', type: 'text', required: true },
    { key: 'description', label: 'Description', type: 'text', required: false },
    { key: 'passengers', label: 'Passengers', type: 'number', required: true },
    { key: 'luggages', label: 'Luggages', type: 'number', required: true },
    { key: 'min_pay', label: 'Min Pay', type: 'number', required: true },
    { key: 'min_distances', label: 'Min Distances', type: 'number', required: true },
    { key: 'after_min', label: 'After Min', type: 'number', required: true },
    { key: 'airport_charge', label: 'Airport Charge', type: 'number', required: true },
    { key: 'min_hours', label: 'Min Hours', type: 'number', required: true },
    { key: 'min_hours_pay', label: 'Min Hours Pay', type: 'number', required: true },
    { key: 'after_min_hours', label: 'After Min Hours', type: 'number', required: true },
]

onMounted(fetchFleets)

function openModal(fleet = null) {
    editingFleet.value = fleet ? { ...fleet } : {}
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    editingFleet.value = {}
}

async function fetchFleets() {
    const res = await fetch('/admin/api/fleets')
    const data = await res.json()
    fleets.value = data.map(f => ({ ...f, showDetails: false }))
}
const handleDelete = (e) => {
    if (confirm('Are you sure to delete?')) {
        e.target.submit(); // proceed with form submission
    }
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
