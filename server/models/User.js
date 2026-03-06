const mongoose = require('mongoose');
const bcrypt = require('bcryptjs');
const { v4: uuidv4 } = require('uuid');

const userSchema = new mongoose.Schema(
  {
    name: { type: String, required: true, trim: true },
    email: { type: String, required: true, unique: true, lowercase: true },
    password: { type: String, required: true, minlength: 6 },
    phone: { type: String },
    country: { type: String },
    role: { type: String, enum: ['user', 'distributor', 'admin'], default: 'user' },
    dxnMemberId: { type: String },
    referralCode: { type: String, unique: true, default: () => uuidv4().split('-')[0].toUpperCase() },
    referredBy: { type: mongoose.Schema.Types.ObjectId, ref: 'User', default: null },
    isActive: { type: Boolean, default: true },
    profileImage: { type: String, default: '' },
    bio: { type: String, default: '' },
    totalSales: { type: Number, default: 0 },
    totalDownlines: { type: Number, default: 0 },
  },
  { timestamps: true }
);

userSchema.pre('save', async function (next) {
  if (!this.isModified('password')) return next();
  this.password = await bcrypt.hash(this.password, 12);
  next();
});

userSchema.methods.comparePassword = async function (candidatePassword) {
  return bcrypt.compare(candidatePassword, this.password);
};

module.exports = mongoose.model('User', userSchema);
