<template>
    <div id="app">
      <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
          <div class="logo">
            <span class="material-icons">dashboard</span> My Dashboard
          </div>
          <ul class="nav">
            <li @click="changeTab('dashboard')" :class="{ active: activeTab === 'dashboard' }">
              <span class="material-icons">home</span> Dashboard
            </li>
            <li @click="changeTab('users')" :class="{ active: activeTab === 'users' }">
              <span class="material-icons">group</span> Users
            </li>
            <li @click="changeTab('reports')" :class="{ active: activeTab === 'reports' }">
              <span class="material-icons">assessment</span> Reports
            </li>
            <li @click="changeTab('settings')" :class="{ active: activeTab === 'settings' }">
              <span class="material-icons">settings</span> Settings
            </li>
          </ul>
        </div>
  
        <!-- Main Content -->
        <div class="main-content">
          <header>
            <div class="top-navbar">
              <span class="title">Dashboard</span>
              <div class="user-actions">
                <button class="btn"><span class="material-icons">notifications</span></button>
                <button class="btn"><span class="material-icons">account_circle</span></button>
              </div>
            </div>
          </header>
  
          <!-- Dynamic Content Based on Active Tab -->
          <div class="content">
            <div v-if="activeTab === 'dashboard'">
              <h2>Welcome to the Dashboard</h2>
              <div class="cards">
                <div class="card" v-for="card in dashboardCards" :key="card.title">
                  <h3>{{ card.title }}</h3>
                  <p>{{ card.value }}</p>
                </div>
              </div>
            </div>
  
            <div v-if="activeTab === 'users'">
              <h2>Users</h2>
              <p>Manage users here.</p>
            </div>
  
            <div v-if="activeTab === 'reports'">
              <h2>Reports</h2>
              <p>View reports here.</p>
            </div>
  
            <div v-if="activeTab === 'settings'">
              <h2>Settings</h2>
              <p>Adjust your settings here.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "App",
    data() {
      return {
        activeTab: 'dashboard', // Default active tab
        dashboardCards: [
          { title: 'Total Users', value: '1,250' },
          { title: 'Sales', value: '$10,500' },
          { title: 'Orders', value: '540' },
          { title: 'Pending Tasks', value: '10' }
        ]
      };
    },
    methods: {
      changeTab(tab) {
        this.activeTab = tab;
      }
    }
  };
  </script>
  
  <style scoped>
  /* Material Design Global Styles */
  @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
  
  /* General Styles */
  body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f7fc;
    color: #333;
  }
  
  /* Main Dashboard Container */
  .dashboard-container {
    display: flex;
    height: 100vh;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  /* Sidebar Styles */
  .sidebar {
    width: 240px;
    background-color: #fff;
    color: #007bff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
  }
  
  .sidebar .logo {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    color: #007bff;
  }
  
  .sidebar .logo .material-icons {
    margin-right: 8px;
  }
  
  .sidebar .nav {
    list-style: none;
    padding: 0;
  }
  
  .sidebar .nav li {
    padding: 12px 16px;
    margin: 4px 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    border-radius: 5px;
    transition: background-color 0.3s, transform 0.2s;
    color: #007bff;
  }
  
  .sidebar .nav li:hover {
    background-color: #f0f0f0;
    transform: scale(1.05);
  }
  
  .sidebar .nav li.active {
    background-color: #007bff;
    color: white;
  }
  
  .sidebar .nav li .material-icons {
    margin-right: 10px;
  }
  
  /* Main Content Styles */
  .main-content {
    flex-grow: 1;
    padding: 20px;
    background-color: #f9f9f9;
  }
  
  .top-navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }
  
  .top-navbar .title {
    font-size: 24px;
    color: #007bff;
  }
  
  .top-navbar .user-actions button {
    background-color: transparent;
    color: #007bff;
    border: 1px solid #007bff;
    border-radius: 50%;
    padding: 8px;
    margin: 2px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .top-navbar .user-actions button:hover {
    background-color: #f0f0f0;
  }
  
  .top-navbar .user-actions button .material-icons {
    font-size: 24px;
  }
  
  /* Content Styles */
  .content {
    margin-top: 20px;
  }
  
  .cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
  }
  
  .card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    flex: 1 1 calc(25% - 20px);
    margin-bottom: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
  }
  
  .card h3 {
    margin-top: 0;
  }
  
  .card p {
    font-size: 18px;
    font-weight: bold;
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .cards {
      flex-direction: column;
    }
    .card {
      flex: 1 1 100%;
    }
  }
  </style>