import React from 'react';
import { List } from 'react-native-paper';

import { Match } from '../types/match';

interface MatchHistoryProps {
  name: string;
  matchHistory: Match[];
}

export const MatchHistory: React.FC<MatchHistoryProps> = ({
  name,
  matchHistory,
}) => {
  return (
    <List.Item
      title="Match"
      description="Result"
      left={(props) => <List.Icon {...props} icon="star" />}
    />
  );
};
