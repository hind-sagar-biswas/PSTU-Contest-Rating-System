<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import Sample from './Partials/Sample.vue';
import { useForm } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

const form = useForm({
    json: '',
    date: '',
});

const submit = () => {
    form.clearErrors();

    if (!form.date) {
        form.setError('date', 'Please select a date');
        return;
    }
    const selected = new Date(form.date);
    const today = new Date();
    // zero out time for comparison
    selected.setHours(0, 0, 0, 0);
    today.setHours(0, 0, 0, 0);

    if (selected > today) {
        form.setError('date', 'Date cannot be in the future');
        return;
    }

    let data;
    // Validate JSON
    try {
        data = JSON.parse(form.json);
    } catch (e) {
        form.setError('json', 'Invalid JSON format');
        return;
    }

    if (!Array.isArray(data)) {
        form.setError('json', 'Data must be an array of objects');
        return;
    }

    for (let i = 0; i < data.length; i++) {
        const item = data[i];
        if (typeof item !== 'object' || item === null) {
            form.setError('json', `Entry #${i + 1} is not an object`);
            return;
        }

        const keys = Object.keys(item).sort();
        const expected = ['name', 'penalty', 'solved', 'standing'].sort();
        if (JSON.stringify(keys) !== JSON.stringify(expected)) {
            form.setError('json', `Entry #${i + 1} must have exactly the keys: name, standing, solved, penalty`);
            return;
        }

        if (typeof item.name !== 'string') {
            form.setError('json', `Entry #${i + 1} → "name" must be a string`);
            return;
        }
        if (!Number.isInteger(item.standing)) {
            form.setError('json', `Entry #${i + 1} → "standing" must be an integer`);
            return;
        }
        if (!Number.isInteger(item.solved)) {
            form.setError('json', `Entry #${i + 1} → "solved" must be an integer`);
            return;
        }
        if (!Number.isInteger(item.penalty)) {
            form.setError('json', `Entry #${i + 1} → "penalty" must be an integer`);
            return;
        }
    }

    const names = data.map(item => item.name);
    const dupes = names.filter((name, idx) => names.indexOf(name) !== idx);
    if (dupes.length) {
        const uniqueDupes = [...new Set(dupes)];
        form.setError('json', `Duplicate names found: ${uniqueDupes.join(', ')}`);
        return;
    }

    form.post(route('contests.store'), {
        data: { date: form.date, json: data },
        preserveState: true,
    });
}
</script>


<template>

    <Head title="Dashboard" />

    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div class="bg-base-200 p-4 shadow-sm sm:rounded-lg sm:p-8">
                    <form @submit.prevent="submit" class="mt-6 space-y-6">
                        <div>
                            <p class="text-md">Data Structure</p>
                            <p class="text-sm text-gray-500">Data should be in JSON</p>
                            <div class="mockup-code w-full mt-2">
                                <Sample />
                            </div>
                        </div>
                        <div>
                            <InputLabel for="json" value="Contest Data (JSON)" />
                            <InputError :message="form.errors.json" class="mt-2" />

                            <TextArea id="json" v-model="form.json" class="mt-1 block w-full min-h-[400px]" required />

                            <InputError :message="form.errors.json" class="mt-2" />
                        </div>

                        <div>
                            <InputLabel for="date" value="Held On" />

                            <TextInput id="date" v-model="form.date" type="date" class="mt-1 block w-full" required />

                            <InputError :message="form.errors.date" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                            <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                                    Saved.
                                </p>
                            </Transition>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </Layout>
</template>
