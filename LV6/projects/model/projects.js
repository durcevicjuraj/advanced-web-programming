var mongoose = require('mongoose');
var projectSchema = new mongoose.Schema({
  name: String,
  description: String,
  price: Number,
  completedTasks: String,
  startDate: { type: Date, default: Date.now },
  endDate: Date,
  teamMembers: [String]
});
mongoose.model('Project', projectSchema);
