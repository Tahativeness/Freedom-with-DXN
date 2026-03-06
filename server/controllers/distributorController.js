const User = require('../models/User');
const Order = require('../models/Order');

// GET /api/distributors/dashboard
const getDashboard = async (req, res) => {
  try {
    const user = await User.findById(req.user.id).select('-password');
    const downlines = await User.find({ referredBy: req.user.id }).select('name email createdAt totalDownlines');
    const orders = await Order.find({ user: req.user.id }).populate('items.product', 'name image').sort({ createdAt: -1 }).limit(5);
    const totalOrders = await Order.countDocuments({ user: req.user.id });

    res.json({ user, downlines, recentOrders: orders, totalOrders });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// GET /api/distributors/downlines
const getDownlines = async (req, res) => {
  try {
    const downlines = await User.find({ referredBy: req.user.id })
      .select('name email phone country createdAt totalDownlines totalSales referralCode')
      .sort({ createdAt: -1 });
    res.json(downlines);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// GET /api/distributors/all (admin)
const getAllDistributors = async (req, res) => {
  try {
    const distributors = await User.find({ role: { $in: ['distributor', 'user'] } })
      .select('-password')
      .populate('referredBy', 'name email')
      .sort({ createdAt: -1 });
    res.json(distributors);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// PUT /api/distributors/:id/role (admin)
const updateRole = async (req, res) => {
  try {
    const user = await User.findByIdAndUpdate(req.params.id, { role: req.body.role }, { new: true }).select('-password');
    res.json(user);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

// GET /api/distributors/referral-link
const getReferralInfo = async (req, res) => {
  try {
    const user = await User.findById(req.user.id).select('referralCode name');
    const referralLink = `${process.env.CLIENT_URL}/register?ref=${user.referralCode}`;
    res.json({ referralCode: user.referralCode, referralLink });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
};

module.exports = { getDashboard, getDownlines, getAllDistributors, updateRole, getReferralInfo };
