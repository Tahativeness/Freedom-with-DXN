const express = require('express');
const router = express.Router();
const { getDashboard, getDownlines, getAllDistributors, updateRole, getReferralInfo } = require('../controllers/distributorController');
const { authMiddleware, adminMiddleware } = require('../middleware/auth');

router.get('/dashboard', authMiddleware, getDashboard);
router.get('/downlines', authMiddleware, getDownlines);
router.get('/referral-link', authMiddleware, getReferralInfo);
router.get('/all', authMiddleware, adminMiddleware, getAllDistributors);
router.put('/:id/role', authMiddleware, adminMiddleware, updateRole);

module.exports = router;
