<script setup>
import { ref, reactive, onMounted, watch } from 'vue';
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const model = page.props.query.model;

// Define active menu and fleet props
const useActiveMenu = ref(1);
// defineProps({ fleets: Array });
const fleets= ref([]);
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

// Reactive form data
const form = reactive({
    bookingType: 'standard',
    pickup: "",
    dropoff: "",
    date: "",
    time: "",
    flight: "",
    fare: null,
    distance: null,
    fleet: null,
    passenger: {},
    return_date: null,
    return_time: null,
    hasReturn: false
});
const now = new Date();

// Define map and directions variables
let directionsService;
const changeType = (value) => {
    form.bookingType = value;
    if(form.bookingType === 'airport'){
        form.pickup="";
    }
}
const handleFlightNumber = async () =>{
    if(form.date && form.flight){
        const res = await fetch(`https://api.cab9.co/api/flightinfo/getflightinfo?includeAddress=true&flightDate=${form.date}&flightno=${form.flight}`, {
            method: "GET",
        })
        const result = await res.json();
        const date = new Date(result.LocalArrivalTime);
        form.pickup= result.SuggestedAddress.Name;
        form.date = date.toISOString().split('T')[0];
        form.time = date.toTimeString().slice(0, 5);
    }
    console.log(form.date)

}
const handleSubmitPay = () => {
    // Create a new form element
    const formElement = document.createElement('form');
    formElement.method = 'POST';
    formElement.action = '/checkout'; // Your endpoint
    if (model==="withoutPayment"){
        form.admin = true
    }
    form._token=csrfToken;
    // Loop through the form object and create hidden inputs for each field
    for (const key in form) {
        if (form.hasOwnProperty(key)) {
            const inputElement = document.createElement('input');
            inputElement.type = 'hidden'; // Hidden input field
            inputElement.name = key; // Name attribute (this corresponds to form data keys)
            inputElement.value = key === 'passenger' ? JSON.stringify(form[key]) : form[key]; // If the key is 'passenger', serialize it as JSON
            formElement.appendChild(inputElement); // Append input to form
        }
    }


    document.body.appendChild(formElement);
    formElement.submit();
};

// Watch for changes in pickup and dropoff addresses
watch(() => [form.pickup, form.dropoff], () => {
    if (form.pickup && form.dropoff) {
        updateMap();
    }
}, { immediate: true });


// Load Google Maps API and initialize autocomplete
onMounted(async () => {
    const handleAutocomplete = (inputId, field) => {
        const input = document.getElementById(inputId);
        let autocomplete = null;

        input.addEventListener('input', () => {
            if (input.value.length >= 3) {
                if (!autocomplete) {
                    autocomplete = new google.maps.places.Autocomplete(input, {
                        types: ['geocode'],
                        componentRestrictions: { country: 'uk' },
                    });

                    autocomplete.addListener('place_changed', () => {
                        const place = autocomplete.getPlace();
                        form[field] = place.formatted_address || place.name;
                    });
                }
            } else {
                if (autocomplete) {
                    autocomplete.unbindAll();
                    autocomplete = null;
                }
            }
        });
    };
    // Initialize autocomplete for pickup and dropoff fields
    handleAutocomplete('pickup', 'pickup');
    handleAutocomplete('dropoff', 'dropoff');

    directionsService = new google.maps.DirectionsService();
});

// Function to update the map with directions
const updateMap = () => {
    const request = {
        origin: form.pickup,
        destination: form.dropoff,
        travelMode: google.maps.TravelMode.DRIVING,
    };

    directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
            const distanceInMeters = result.routes[0].legs[0].distance.value;
            const distance = Math.round(distanceInMeters / 1609.34); // Convert meters to miles and round to integer
            form.distance = distance; // Update the distance in miles (integer)
        }
    });
};

async function fetchFleets() {
    const res = await fetch('/search/api/fleets', {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json', // Specify JSON content type
        },
        body: JSON.stringify(form), // Pass the form data
    })
    const data = await res.json()
    fleets.value = data;
}

watch(form, ()=>{
    if(form.time && form.date && form.distance && form.pickup && form.dropoff
        && form.passenger.people && form.passenger.luggages){
        fetchFleets();
    }
})
watch(
    () => [form.passenger.luggages, form.passenger.people, form.hasReturn],
    ([newLuggages, newPeople, newHasReturn]) => {
        form.fleet = null;
        form.fare = null;
    }
);
</script>

<template>
    <main class="main">
        <section class="section">
            <div class="container-sub">
                <div class="box-booking-tabs">
                    <div class="item-tab wow fadeInUp active"><a href="#vehicle" @click="useActiveMenu=1">
                        <div class="box-tab-step" :class="useActiveMenu >= 1&& 'active'">
                            <div class="icon-tab"> <span class="icon-book icon-vehicle"> </span><span class="text-tab">Vehicle </span></div>
                            <div class="number-tab"> <span>01</span></div>
                        </div></a></div>
                    <div class="item-tab wow fadeInUp"><a href="#passenger-details" @click="()=>{
                        if(form.fare && form.fleet){
                            if(form.hasReturn){
                                if(form.return_date && form.return_time){
                                    useActiveMenu=2
                                }
                            }else{
                                useActiveMenu=2
                            }
                        }
                    }">
                        <div class="box-tab-step" :class="useActiveMenu >= 2 && 'active'">
                            <div class="icon-tab"> <span class="icon-book icon-pax"> </span><span class="text-tab">Passenger  </span></div>
                            <div class="number-tab"> <span>02</span></div>
                        </div></a></div>
                    <div class="item-tab wow fadeInUp"><a href="#payment" @click="()=>{if(form.fare && form.fleet && form.passenger.name && form.passenger.email && form.passenger.phone) useActiveMenu=3}">
                        <div class="box-tab-step" :class="useActiveMenu === 3 && 'active'">
                            <div class="icon-tab"> <span class="icon-book icon-payment"> </span><span class="text-tab">Payment  </span></div>
                            <div class="number-tab"> <span>03</span></div>
                        </div></a></div>
                </div>
                <div class="box-row-tab mt-20 mb-20">
                    <h3>Your booking time should be 360 minutes more than current time</h3>
                    <div class="box-tab-left">
                        <section :class="useActiveMenu!==1&&'d-none'" class="row">
                            <h5 class="my-2">Choose Type</h5>
                            <div class="row typeChoose">
                                <div class="col-4">
                                    <label>
                                        <input type="radio" name="option" checked v-model="form.bookingType" value="standard" @change="changeType('standard')">
                                        <span class="custom-radio"></span> Standard
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input type="radio" name="option" v-model="form.bookingType" value="airport" @change="changeType('airport')" >
                                        <span class="custom-radio"></span> Airport Pickup
                                    </label>
                                </div>
                                <div class="col-4">
                                    <label>
                                        <input type="radio" name="option" v-model="form.bookingType" value="hourly" @change="changeType('hourly')">
                                        <span class="custom-radio"></span> Hourly
                                    </label>
                                </div>
                            </div>
                            <div class="row mt-30" v-if="form.bookingType==='standard'">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="pickup">Pickup Address*</label>
                                        <input class="form-control" v-model="form.pickup" id="pickup" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="dropoff">Drop off Address*</label>
                                        <input class="form-control" id="dropoff" v-model="form.dropoff"  type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="date">Select Date*</label>
                                        <input class="form-control" v-model="form.date" id="date" :min="now.toISOString().split('T')[0]" type="date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="time">Booking Time*</label>
                                        <input class="form-control" v-model="form.time" id="time" type="time">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="passenger">Number of Passenger*</label>
                                        <input class="form-control" v-model="form.passenger.people" id="passenger" type="number" min="1" value="1">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="luggages">Number of Luggages*</label>
                                        <input class="form-control" id="luggages" v-model="form.passenger.luggages" type="number" min="1"  value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30" v-else-if="form.bookingType==='airport'">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="flight_date">Flight Date*</label>
                                        <input class="form-control" @input="handleFlightNumber()" id="flight_date" :min="now.toISOString().split('T')[0]"  v-model="form.date" type="date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="flight_number">Flight Number*</label>
                                        <input class="form-control" id="flight_number" @input="handleFlightNumber()"
                                               :disabled="form.date===''" v-model="form.flight" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-bottom: 14px;" v-if="form.pickup">
                                    <div class="form-group focused">
                                        <label class="form-label" for="airport_pickup">Pickup Address:  <b class="text-dark">{{form.pickup}} </b> (Estimated Arrival Time: <b>{{form.time}}</b>)</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-label" for="dropoff">Drop Off Address*</label>
                                        <input class="form-control" id="dropoff" v-model="form.dropoff" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="passenger">Number of Passenger*</label>
                                        <input class="form-control" id="passenger" type="number"  v-model="form.passenger.people" min="1"  value="1">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="luggages">Number of Luggages*</label>
                                        <input class="form-control" id="luggages" type="number"   v-model="form.passenger.luggages" min="1"  value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-30" v-else>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="date">Select Date*</label>
                                        <input class="form-control" id="date" type="date" :min="now.toISOString().split('T')[0]" v-model="form.date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="flight_number">Booking Time*</label>
                                        <input class="form-control" id="flight_number" type="time"  v-model="form.time">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="pickup">Pickup Address*</label>
                                        <input class="form-control" id="pickup" type="text"  v-model="form.pickup">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="duration">Booking Duration*</label>
                                        <select class="form-control" style="padding:15px" id="duration" v-model="form.distance">
                                            <option :value="i" v-for="i in 24">{{i}} Hour{{i!==1?'s':''}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="passenger">Number of Passenger*</label>
                                        <input class="form-control" id="passenger" type="number" value="1" v-model="form.passenger.people" min="1" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="luggages">Number of Luggages*</label>
                                        <input class="form-control" id="luggages" type="number" value="1" v-model="form.passenger.luggages" min="1" >
                                    </div>
                                </div>
                            </div>
                            <label v-if="form.bookingType !== 'hourly'" class="pb-30" style="user-select: none">
                                <input type="checkbox" name="hasReturn" v-model="form.hasReturn">
                                <span class="custom-checkbox mr-5" style="top: 6px"></span>I will Return
                            </label>
                            <template v-if="form.hasReturn && form.bookingType !== 'hourly'">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="r_date">Return Date*</label>
                                        <input class="form-control" id="r_date" type="date" :min="form.date" placeholder="Enter Return Date" v-model="form.return_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="r_time">Return Time*</label>
                                        <input class="form-control" id="r_time" type="time" placeholder="Enter Return Time" v-model="form.return_time">
                                    </div>
                                </div>
                            </template>
                        </section>
                        <section  :class="useActiveMenu!==2&&'d-none'" class="row">
                            <h5 class="mb-4">Passenger Details</h5>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-label" for="fullname">First Name</label>
                                        <input class="form-control" id="fullname" v-model="form.passenger.name" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="email">Email Address</label>
                                        <input class="form-control" id="email" v-model="form.passenger.email" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-label" for="phone">Phone Number</label>
                                        <input class="form-control" id="phone" placeholder="Your Phone Number with Country Code" v-model="form.passenger.phone" type="text">
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100" style="margin-top: 20px" @click="useActiveMenu=3"
                                        :disabled="!form.passenger.name || !form.passenger.email || !form.passenger.phone">Next</button>
                            </div>
                        </section>
                        <section :class="useActiveMenu !== 3 && 'd-none'" class="row">
                                <button class="btn btn-primary" type="submit" @click="handleSubmitPay()">
                                    {{model==="withoutPayment" ? 'Confirm & Generate Payment Link' : 'Confirm & Pay'}}
                                </button>
                        </section>
                    </div>
                    <div class="box-tab-right">
                        <section v-if="form.pickup && form.dropoff">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h4 class="py-2">Route Overview</h4>
                                    <p><strong>Pickup:</strong> {{ form.pickup }}</p>
                                    <p><strong>Drop off:</strong> {{ form.dropoff }}</p>
                                    <p><strong>Distance:</strong> {{ form.distance }} Mile(s)</p>
                                    <p><strong>Booking Date & Time:</strong> {{form.date}} {{ form.time }}</p>
                                </div>
                            </div>
                        </section>
                        <h4 class="p-0 mb-2">Available Fleets</h4>
                        <div class="choose-fleets">
                            <div class="d-flex item-fleet align-items-center p-1"
                                 :class="form.fleet===fleet.id && 'active_fleet'"
                                 v-for="fleet in fleets" :key="fleet.id"
                                @click="()=>{
                                    form.fleet=fleet.id;
                                    form.fare=fleet.price
                                }">
                                <img :src="fleet.image" style="max-width:200px">
                                <div>
                                    <p>{{fleet.name}}</p>
                                    <h4>£{{fleet.price}}</h4>
                                    <div class="d-flex gap-2">
                                        <img :src="'/assets/imgs/template/icons/friend.svg'"/>
                                        <span>{{fleet.passengers}}</span>
                                        <img :src="'/assets/imgs/template/icons/luggage.svg'"/>
                                        <span>{{fleet.luggages}}</span>
                                    </div>
                                </div>
                            </div>
                            <section v-if="fleets.length===0">
                                <p>Please Fill the form to select a fleet</p>
                            </section>
                            <button class="btn btn-primary w-100" style="margin-top: 20px" @click="()=>{
                                if(form.fare && form.fleet){
                                    if(form.hasReturn){
                                        if(form.return_date && form.return_time){
                                            useActiveMenu=2
                                        }
                                    }else{
                                        useActiveMenu=2
                                    }
                                }
                            }"
                            :disabled="!form.fare || !form.fleet">Select Fleet</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
<style>
/* Hide default radio button */
input[type="radio"] {
    display: none;
}

/* Custom radio button */
.custom-radio {
    display: inline-block;
    width: 24px;
    height: 24px;
    border: 2px solid black;
    border-radius: 50%;
    position: relative;
    cursor: pointer;
}

/* Inner circle (checked state) */
.custom-radio::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 12px;
    height: 12px;
    background-color: black;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

/* Show inner circle when selected */
input[type="radio"]:checked + .custom-radio::after {
    opacity: 1;
}

input[type="checkbox"] {
    display: none;
}

/* Custom checkbox container */
.custom-checkbox {
    display: inline-block;
    width: 24px;
    height: 24px;
    border: 2px solid black;
    border-radius: 4px;
    position: relative;
    cursor: pointer;
    scale: 0.8;
}

/* Checkmark */
.custom-checkbox::after {
    content: "";
    position: absolute;
    left: 6px;
    top: 2px;
    width: 8px;
    height: 14px;
    border: solid white;
    border-width: 0 3px 3px 0;
    transform: rotate(45deg);
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
}

/* Checked state */
input[type="checkbox"]:checked + .custom-checkbox {
    background-color: black;
}

input[type="checkbox"]:checked + .custom-checkbox::after {
    opacity: 1;
}
.typeChoose label{
    display: flex;
    align-items: center;
    gap: 5px;
}
.choose-fleets .item-fleet{
    border-bottom:1px solid #ddd;
    cursor: pointer;
}

.choose-fleets .item-fleet.active_fleet {
    border:1px solid #7b7b7b;
    background:#f8f8f8
}
</style>
