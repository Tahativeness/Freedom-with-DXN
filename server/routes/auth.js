const express = require('express');
const router = express.Router();
const bcrypt = require('bcryptjs');
const { register, login, getMe, updateProfile } = require('../controllers/authController');
const { authMiddleware, adminMiddleware } = require('../middleware/auth');
const ContactMessage = require('../models/ContactMessage');
const User = require('../models/User');

router.post('/register', register);
router.post('/login', login);
router.get('/me', authMiddleware, getMe);
router.put('/profile', authMiddleware, updateProfile);

// PUT /api/auth/change-password
router.put('/change-password', authMiddleware, async (req, res) => {
  try {
    const { currentPassword, newPassword } = req.body;
    const user = await User.findById(req.user.id);
    const ok = await user.comparePassword(currentPassword);
    if (!ok) return res.status(400).json({ message: 'Current password is incorrect' });
    user.password = newPassword;
    await user.save();
    res.json({ message: 'Password updated successfully' });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// POST /api/auth/create-admin (admin only)
router.post('/create-admin', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    const { name, email, password, phone, country } = req.body;
    if (!name || !email || !password) return res.status(400).json({ message: 'Name, email and password are required' });
    const existing = await User.findOne({ email });
    if (existing) return res.status(400).json({ message: 'Email already registered' });
    const user = await User.create({ name, email, password, phone, country, role: 'admin' });
    res.status(201).json({ message: 'Admin created successfully', user: { id: user._id, name: user.name, email: user.email, role: user.role } });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// GET /api/auth/users (admin only)
router.get('/users', authMiddleware, adminMiddleware, async (req, res) => {
  try {
    const users = await User.find().select('-password').sort({ createdAt: -1 });
    res.json(users);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Contact form
router.post('/contact', async (req, res) => {
  try {
    const msg = await ContactMessage.create(req.body);
    res.status(201).json({ message: 'Message sent successfully', id: msg._id });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

module.exports = router;
