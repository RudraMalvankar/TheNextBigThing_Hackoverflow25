export interface Subject {
  name: string;
  importance: number; // 1-5
  topics: string[];
}

export interface StudyPlan {
  subject: string;
  hoursPerDay: number;
  keyPoints: string[];
  dailyGoals: string[];
  aiRecommendations?: string[];
}

export interface StudyInput {
  subjects: Subject[];
  daysRemaining: number;
}