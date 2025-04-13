<script setup>
defineProps({
    passengers: Array,
})
</script>

<template>
    <div class="flex justify-between items-center mb-4">
        <h2 class="ml-5 mt-5 text-2xl font-bold text-yellow-400">Pasengers</h2>
    </div>
    <div class="overflow-x-auto p-2">
        <table class="min-w-full divide-y divide-gray-700 bg-gray-900 text-white">
            <thead class="bg-gray-800">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                    Phone
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                <tr class="hover:bg-gray-800" v-for="passenger in passengers">
                    <td class="px-6 py-4 whitespace-nowrap">{{passenger.name}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ passenger.email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ passenger.phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<style scoped>

</style>
