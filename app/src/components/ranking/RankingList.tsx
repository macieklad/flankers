import * as React from 'react';
import { FlatList, ListRenderItemInfo, StyleSheet, View } from 'react-native';
import { List, useTheme } from 'react-native-paper';

import { TeamProfilePayload } from '../../types/teamProfile';
import { UserProfilePayload } from '../../types/userProfilePayload';
import { AppText } from '../shared/AppText';
import { Avatar } from '../shared/Avatar';

interface PlayersRankingProps {
  data: TeamProfilePayload[] | UserProfilePayload[];
  pageNumber: number;
  userId?: number;
  userTeamId?: string;
  buttonGroup: React.ComponentElement<any, any>;
}

export const RankingList: React.FC<PlayersRankingProps> = ({
  data,
  pageNumber,
  userId,
  userTeamId,
  buttonGroup,
}) => {
  const theme = useTheme();

  const renderItem = ({
    item,
    index,
  }: ListRenderItemInfo<TeamProfilePayload | UserProfilePayload>) => (
    <List.Item
      title={item.name}
      titleStyle={styles.elementName}
      description={`${item.elo} punktów rankingowych`}
      accessibilityComponentType=""
      accessibilityTraits=""
      left={() => (
        <View style={styles.elementAvatarContainer}>
          <Avatar
            size={40}
            borderRadius={8}
            src={{ uri: item.versioned_avatar }}
          />
        </View>
      )}
      right={() => (
        <AppText style={styles.rightIndexStyle}>
          #{index + (pageNumber - 1) * 10 + 1}
        </AppText>
      )}
      style={
        userId
          ? item.id === userId
            ? {
                backgroundColor: theme.colors.primary,
                borderRadius: 8,
                opacity: 0.5,
              }
            : { backgroundColor: theme.colors.white }
          : item.id === parseInt(userTeamId!, 10)
          ? {
              backgroundColor: theme.colors.primary,
              borderRadius: 8,
              opacity: 0.5,
            }
          : { backgroundColor: theme.colors.white }
      }
    />
  );

  return (
    <FlatList
      data={data as any}
      renderItem={renderItem}
      contentContainerStyle={styles.container}
      keyExtractor={(player) => player.id.toString()}
      ListFooterComponent={buttonGroup}
    />
  );
};

const styles = StyleSheet.create({
  container: {
    paddingHorizontal: 16,
  },
  elementName: {
    fontWeight: 'bold',
  },
  elementAvatarContainer: {
    justifyContent: 'center',
    marginRight: 4,
  },
  rightIndexStyle: {
    fontWeight: 'bold',
    textAlign: 'justify',
    marginRight: 12,
    paddingTop: 6,
  },
});
