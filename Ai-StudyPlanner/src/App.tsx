import React, { useState } from 'react';
import { Brain, Calendar, Clock } from 'lucide-react';
import { Subject, StudyPlan } from './types';
import SubjectForm from './components/SubjectForm';
import StudyPlanDisplay from './components/StudyPlanDisplay';
import { getStudyRecommendations } from './lib/gemini';

function App() {
  const [subjects, setSubjects] = useState<Subject[]>([]);
  const [daysRemaining, setDaysRemaining] = useState<number>(30);
  const [studyPlan, setStudyPlan] = useState<StudyPlan[]>([]);
  const [isGenerating, setIsGenerating] = useState(false);

  const generateStudyPlan = async () => {
    setIsGenerating(true);
    const totalImportance = subjects.reduce((sum, subject) => sum + subject.importance, 0);
    const studyHoursPerDay = 8; // Assuming 8 hours of study per day

    try {
      const planPromises = subjects.map(async subject => {
        const hoursPerDay = (subject.importance / totalImportance) * studyHoursPerDay;
        const aiRecommendations = await getStudyRecommendations(subject.name, subject.topics, daysRemaining);
        
        return {
          subject: subject.name,
          hoursPerDay: Math.round(hoursPerDay * 10) / 10,
          keyPoints: subject.topics,
          dailyGoals: [
            "Review previous day's material",
            "Study new concepts",
            "Practice problems",
            "Take short breaks every hour"
          ],
          aiRecommendations
        };
      });

      const plan = await Promise.all(planPromises);
      setStudyPlan(plan);
    } catch (error) {
      console.error('Error generating study plan:', error);
    } finally {
      setIsGenerating(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
      <div className="container mx-auto px-4 py-8">
        <div className="text-center mb-12">
          <div className="flex items-center justify-center mb-4">
            <Brain className="w-12 h-12 text-indigo-600" />
          </div>
          <h1 className="text-4xl font-bold text-gray-800 mb-2">AI Study Planner</h1>
          <p className="text-gray-600">Create your personalized study schedule</p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <div className="space-y-6">
            <div className="bg-white p-6 rounded-xl shadow-lg">
              <div className="flex items-center mb-4">
                <Calendar className="w-6 h-6 text-indigo-600 mr-2" />
                <h2 className="text-xl font-semibold">Days Until Exam</h2>
              </div>
              <input
                type="number"
                min="1"
                value={daysRemaining}
                onChange={(e) => setDaysRemaining(Number(e.target.value))}
                className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                placeholder="Enter days remaining"
              />
            </div>

            <div className="bg-white p-6 rounded-xl shadow-lg">
              <div className="flex items-center mb-4">
                <Clock className="w-6 h-6 text-indigo-600 mr-2" />
                <h2 className="text-xl font-semibold">Subjects</h2>
              </div>
              <SubjectForm subjects={subjects} setSubjects={setSubjects} />
            </div>

            <button
              onClick={generateStudyPlan}
              disabled={isGenerating}
              className={`w-full bg-indigo-600 text-white py-3 px-6 rounded-lg transition-colors duration-200 font-semibold ${
                isGenerating ? 'opacity-75 cursor-not-allowed' : 'hover:bg-indigo-700'
              }`}
            >
              {isGenerating ? 'Generating Study Plan...' : 'Generate Study Plan'}
            </button>
          </div>

          <div className="bg-white p-6 rounded-xl shadow-lg">
            <StudyPlanDisplay plan={studyPlan} daysRemaining={daysRemaining} />
          </div>
        </div>
      </div>
    </div>
  );
}

export default App;