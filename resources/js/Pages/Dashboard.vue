<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

let users = [];
let newUser = {
  name: '',
  phone: '',
  email: '',
  password: '',
};
let editedUser = {
  id: null,
  name: '',
  phone: '',
  email: '',
};
let editMode = false;

const fetchUsers = async () => {
  const response = await axios.get('/api/users');
  users = response.data;
};

const createUser = async () => {
  const response = await axios.post('/api/users', newUser);
  users.push(response.data);
  newUser = { name: '', phone: '', email: '' ,password: '$2y$10$dAlhDbgAZ46vWF/GW170n.PBnjgMysa4N6.joRrC/TfDg2UXzOqLe'};
};

const editUser = (user) => {
  editedUser = { ...user };
  editMode = true;
};

const updateUser = async () => {
  const response = await axios.put(`/api/users/${editedUser.id}`, editedUser);
  const index = users.findIndex((user) => user.id === editedUser.id);
  if (index !== -1) {
    users[index] = response.data;
  }
  editMode = false;
  editedUser = { id: null, name: '', phone: '', email: '' };
};

const deleteUser = async (userId) => {
  await axios.delete(`/api/users/${userId}`);
  users = users.filter((user) => user.id !== userId);
};

const cancelEdit = () => {
  editMode = false;
  editedUser = { id: null, name: '', phone: '', email: '' };
};

// Fetch users when the component is mounted
fetchUsers();
</script>


<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            You're logged in!

            <!-- Table to display data -->
            <table class="table-auto">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- {{ user.name }} {{ user.phone }} {{ user.email }} -->
                <tr v-for="(user, index) in users" :key="user.id">
                  <td>{{ user.name }}</td>
                  <td>{{ user.phone }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <button @click="editUser(user.id)">Edit</button>
                    <button @click="deleteUser(user.id)">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Input form to add data -->
            <div class="mt-4">
              <input v-model="newUser.name" type="text" placeholder="Name" class="border rounded p-2">
              <input v-model="newUser.phone" type="text" placeholder="Phone" class="border rounded p-2">
              <input v-model="newUser.email" type="text" placeholder="Email" class="border rounded p-2">
              <input v-model="newUser.password" type="text" placeholder="password" class="border rounded p-2">
              <button @click="createUser" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Add</button>
            </div>

            <!-- Edit User form -->
            <div v-if="editMode">
              <h2>Edit User</h2>
              <input v-model="editedUser.name" type="text" placeholder="Name" class="border rounded p-2">
              <input v-model="editedUser.phone" type="text" placeholder="Phone" class="border rounded p-2">
              <input v-model="editedUser.email" type="text" placeholder="Email" class="border rounded p-2">
              <button @click="updateUser" class="bg-green-500 text-white px-4 py-2 rounded mt-2">Save</button>
              <button @click="cancelEdit" class="bg-red-500 text-white px-4 py-2 rounded mt-2">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

