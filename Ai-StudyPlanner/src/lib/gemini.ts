import { GoogleGenerativeAI } from '@google/generative-ai';

const genAI = new GoogleGenerativeAI(import.meta.env.VITE_GEMINI_API_KEY);

export async function getStudyRecommendations(subject: string, topics: string[], daysRemaining: number) {
  try {
    const model = genAI.getGenerativeModel({ model: 'gemini-pro' });

    const prompt = `You are an expert study coach. A student is preparing for their ${subject} exam in ${daysRemaining} days. 
They need to cover these topics: ${topics.join(', ')}. 

Provide 5-6 highly effective and personalized study recommendations, focusing on:
- Optimized time management based on the remaining days
- The best study techniques for retention and understanding
- Prioritization strategies for high-impact topics
- Practical tips to maintain focus and avoid burnout 

Ensure the advice is clear, actionable, and tailored to their timeframe and subject.`;  


    const result = await model.generateContent(prompt);
    const response = await result.response;
    const text = response.text();
    
    return text.split('\n').filter(line => line.trim().length > 0);
  } catch (error) {
    console.error('Error getting AI recommendations:', error);
    return [
      'Focus on understanding core concepts first',
      'Practice with sample problems regularly',
      'Review and revise topics periodically'
    ];
  }
}