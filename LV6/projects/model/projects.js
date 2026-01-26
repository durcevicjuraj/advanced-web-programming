var mongoose = require('mongoose');
var projectSchema = new mongoose.Schema({
  name: String,
  description: String,
  price: Number,
  completedTasks: String,
  startDate: { type: Date, default: Date.now },
  endDate: Date,
  teamMembers: [{ type: mongoose.Schema.Types.ObjectId, ref: 'User' }],
  leader: { type: mongoose.Schema.Types.ObjectId, ref: 'User' },
  archived: { type: Boolean, default: false }
});
mongoose.model('Project', projectSchema);
