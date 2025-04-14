<template>
    <div class="p-6 text-white">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-yellow-400">Trips</h2>
            <a href="/booking?model=withoutPayment" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 px-4 py-2 rounded-lg font-semibold">
                + Add Booking
            </a>
        </div>
        <div class="flex space-x-4 my-3">
            <!-- Toggle for Upcoming and Pending Trips -->
            <button @click="setView('upcoming')"
                    :class="{
                            'bg-yellow-400 text-gray-800': activeView === 'upcoming',
                            'bg-transparent text-yellow-400 border-2 border-yellow-400': activeView !== 'upcoming'
                        }"
                    class="px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                Upcoming and Pending
            </button>

            <!-- Toggle for Completed Trips -->
            <button @click="setView('completed')"
                    :class="{
                            'bg-yellow-400 text-gray-800': activeView === 'completed',
                            'bg-transparent text-yellow-400 border-2 border-yellow-400': activeView !== 'completed'
                        }"
                    class="px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                Completed
            </button>
        </div>

        <div class="space-y-4">
            <div v-for="trip in completedtrips" v-if="activeView === 'completed'" :key="trip.id" class="bg-gray-800 rounded-lg p-4 shadow">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-300">{{ trip.from }} → {{ trip.to }}</h3>
                        <p class="text-sm text-gray-400">{{ trip.date }} at {{ trip.time }}</p>
                    </div>
                    <div>
                        <button @click="trip.showDetails = !trip.showDetails"
                                class="text-sm text-yellow-400 hover:underline">
                            {{ trip.showDetails ? 'Hide' : 'Details' }}
                        </button>
                    </div>
                </div>
                <div v-if="trip.showDetails" class="mt-3 text-sm text-gray-300 flex justify-between flex-wrap">
                    <div>
                        <p><strong>Flight:</strong> {{ trip.flight_number || 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ getTripTypeText(trip.trip_type) }}</p>
                        <p><strong>Distance:</strong> {{ trip.trip_type === 3 ? `${trip.distance} hours` : `${trip.distance} miles` }}</p>
                        <p><strong>Fare:</strong> £{{ trip.fare }}</p>
                    </div>
                    <div>
                        <p><strong>People:</strong> {{ trip.people }}</p>
                        <p><strong>Luggages:</strong> {{ trip.luggages }}</p>
                        <p><strong>Status:</strong> {{ getStatusText(trip.status) }}</p>
                    </div>
                </div>
            </div>
            <div v-for="trip in upcomingtrips" v-else class="bg-gray-800 rounded-lg p-4 shadow active:bg-gray-400">
                <div class="flex justify-between items-center" :key="trip.id" @dblclick="handleCopy(trip.pay_link)">
                    <div>
                        <template v-if="trip.status === 3">
                            <h3 class="text-lg font-semibold text-yellow-300">{{ trip.to }} → {{ trip.from }}</h3>
                            <p class="text-sm text-gray-400">{{ trip.return_date }} at {{ trip.return_time }} </p>
                        </template>
                        <template v-else>
                            <h3 class="text-lg font-semibold text-yellow-300">{{ trip.from }} → {{ trip.to }}</h3>
                            <p class="text-sm text-gray-400">{{ trip.date }} at {{ trip.time }} </p>
                            <p class="text-sm text-gray-400" v-if="trip.return_date">Return: {{ trip.return_date }} at {{ trip.return_time }} </p>
                        </template>
                    </div>
                    <div>
                        <template v-if="trip.remaining_return === 1 && trip.status != 3">
                            <button class="text-sm text-white-900 bg-black py-1 px-3 rounded mr-3" @click="actionComplete(trip.id, 3)">
                                Complete First Trip
                            </button>
                        </template>
                        <button class="text-sm text-white-900 bg-black py-1 px-3 rounded mr-3" v-else @click="actionComplete(trip.id)">
                        Complete
                        </button>
                        <button @click="trip.showDetails = !trip.showDetails"
                                class="text-sm bg-yellow-500 mt-3 text-black hover:underline py-1 px-3">
                            {{ trip.showDetails ? 'Hide' : 'Details' }}
                        </button>
                    </div>
                </div>
                <div v-if="trip.showDetails" class="mt-3 text-sm text-gray-300 flex justify-between flex-wrap">
                    <div>
                        <p><strong>Flight:</strong> {{ trip.flight_number || 'N/A' }}</p>
                        <p><strong>Type:</strong> {{ getTripTypeText(trip.trip_type) }}</p>
                        <p><strong>Distance:</strong> {{ trip.trip_type === 3 ? `${trip.distance} hours` : `${trip.distance} miles` }}</p>
                        <p><strong>Fare:</strong> £{{ trip.fare }}</p>
                    </div>
                    <div>
                        <p><strong>People:</strong> {{ trip.people }}</p>
                        <p><strong>Luggages:</strong> {{ trip.luggages }}</p>
                        <p><strong>Status:</strong> {{ getStatusText(trip.status) }}</p>
                    </div>
                </div>
            </div>
            <h2 v-if="upcomingtrips.length === 0" class="text-white">No Upcoming Trip</h2>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import {router} from "@inertiajs/vue3";

const completedtrips = ref([])
const upcomingtrips = ref([])

onMounted(fetchTrips)

const activeView = ref('upcoming')

// Set the active view when a button is clicked
function setView(view) {
    activeView.value = view
}

function getStatusText(status) {
    return ['Pending', 'Paid and Upcoming', 'Completed'][status] || 'Unknown'
}

function getTripTypeText(type) {
    return ['Standard', 'Airport', 'Hourly'][type - 1] || 'Unknown'
}

async function fetchTrips() {
    const res = await fetch('/admin/api/trips')
    const data = await res.json()
    const allTrips = data.map(t => ({ ...t, showDetails: false }))

    completedtrips.value = allTrips.filter(t => t.status === 2)
    upcomingtrips.value = allTrips.filter(t => t.status !== 2)
}

const actionComplete  = async (trip, status=2) => {
    let confirmation = confirm('Are you sure to complete this trip?');
    if(confirmation){
        await router.post('/admin/update-booking', {order: trip, status:status});
        window.location.reload();
    }
}

const handleCopy  = (data) =>{
    navigator.clipboard.writeText(data)
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
    border-color: #34d399;
}
</style>
